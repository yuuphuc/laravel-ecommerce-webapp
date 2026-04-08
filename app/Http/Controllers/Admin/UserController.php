<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class UserController extends Controller
{

    public function login()
    {
        // hiển thị trang đăng nhập
        return view('admin.users.login');
    }
    public function loginpost(UserLoginRequest  $req)
    {
        // xử lý đăng nhập
        $user = User::where('email', $req->email)->first();
        // Nếu không tìm thấy người dùng trong bảng users
        if (!$user) {
            // điều hướng về view login theo route name (đặt trong web.php)
            return redirect()->route('ad.login')->with('message', 'Email không tồn tại')->withInput();
        }
        // Nếu tìm thấy người dùng thì kiểm tra mật khẩu
        // do mật khẩu dùng Hash::make() để mã hóa, nên cần so sánh phải dùng với hàm Hash::check()
        $check = Hash::check($req->password, $user->password); // true hoặc false
        // trường hợp mật khẩu không khớp
        if (!$check) {
            // điều hướng về view login theo route name (đặt trong web.php)
            return redirect()->route('ad.login')->with('message', 'Mật khẩu không đúng')->withInput();
        }
        // Nếu thông tin đăng nhập đúng thì lưu thông tin người dùng vào session với Auth::login($user)
        // Nếu biến $remember có giá trị true (nếu người dùng chọn nhớ tài khoản)
        $remember = $req->has('remember') ? true : false;
        Auth::login($user, $remember);
        // sử dụng intended để điều hướng về URL mà người dùng muốn truy cập
        // nếu không có thì điều hướng về dasboard (route name dashboard được khai báo trong web.php)
        return redirect()->intended(route('dashboard'));
    }
    public function logout(Request $req)
    {
        // xử lý đang xuất - chức nang chỉ được sử dung sau khi đang nhập thanh công

        // lấy lại thông tin user đã đang nhập
        $user = Auth::user();

        // xoa remember_token trong bang users
        /** @var \App\Models\User $user */
        if ($user) {
            $user->update(['remember_token' => null]);
        }

        // Xoa thong tin nguoi dung trong session
        Auth::logout();

        // xóa phiên làm việc của người dùng
        $req->session()->invalidate();
        // tạo lại mã CSRF mới
        $req->session()->regenerateToken();

        // Điều hướng ve view login theo route name (khai bao trong web.php)
        return redirect()->route('ad.login');
    }
    public function forgotpassform()
    {
        // xử lý hiển thị form quên mật khẩu
        return view('admin.users.forgotpass');
    }
    public function forgotpass(Request $request)
    {
        // xử lý quên mật khẩu
        $request->validate([
            'email' => 'required|email'
        ], [
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng',
        ]);

        // Kiểm tra xem email co ton tại trong bang users khong
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            // hiển thị thông bao lỗi với tham số message
            return redirect()->route('ad.forgotpass')
                ->with('message', 'Email không tồn tại')
                ->withInput();
        }
        // Sử dụng cách Gửi email với mặt khẩu mới
        $passrandom = Str::random(10); // Tạo mật khẩu ngau nhien dài 10 ký tự
        $passencrypte = Hash::make($passrandom); // mã hóa mật khẩu
        // lưu mat khau vao bang users
        User::where('email', $request->email)->update(['password' => $passencrypte]);
        // Tạo đoạn nội dung mau (HTML)
        $html = "<h2>Mặt khẩu mới của bạn là : $passrandom. Vui lòng đổi mật khẩu sau khi nhận được mật khẩu mới. </h2>";
        // Gửi email
        Mail::html($html, function ($message) use ($request) {
            $message->to($request->email)->subject('Đat lại mật khẩu');
        });
        // Hiển thị thông bao thanh công
        return redirect()->route('ad.forgotpass')
            ->with('message', 'Gui mat khau moi. Vui long kiem tra email cua ban');
    }
    public function changepassform()
    {
        return view('admin.users.changepass');
    }

    public function changepass(Request $request)
    {
        // xử lý đổi mật khẩu
        // chức năng chỉ được sử dụng sau khi đăng nhập thành công
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ], [
            'old_password.required' => 'Vui lòng nhập mật khẩu cũ',
            'new_password.required' => 'Vui lòng nhập mật khẩu mới',
            'new_password.min' => 'Mật khẩu mới ít nhất 6 ký tự',
            'new_password.confirmed' => 'Xác nhận mật khẩu mới không khớp',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->with('message', 'Mật khẩu cũ không đúng');
        }

        /** @var \App\Models\User $user */
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        // Đăng xuất người dùng
        Auth::logout();

        return redirect()->route('ad.login')->with('message', 'Đổi mật khẩu thành công. Vui lòng đăng nhập lại.');
    }
}
