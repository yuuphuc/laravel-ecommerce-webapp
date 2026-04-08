function bindDeleteModal() {
    const modal = document.getElementById('confirmdelete');
    const messageArea = document.getElementById('message-area') || document.body;
    if (!modal) return;

    const modalForm = modal.querySelector('form');
    let currentRow = null;

    modal.removeEventListener('show.bs.modal', modal._handlerShow || (() => {}));
    modalForm.removeEventListener('submit', modalForm._handlerSubmit || (() => {}));

    const handleShow = function (event) {
        const button = event.relatedTarget;
        const info = button.getAttribute('data-info');
        const action = button.getAttribute('data-action');

        modal.querySelector('.modal-body .info').textContent = info;
        modalForm.setAttribute('action', action);
        currentRow = button.closest('tr');
    };

    const handleSubmit = function (e) {
        e.preventDefault();
        const action = modalForm.getAttribute('action');
        const formData = new FormData(modalForm);
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        formData.append('_token', token);

        fetch(action, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(res => res.json())
        .then(res => {
            messageArea.innerHTML = `<div class="alert alert-${res.errorflag}">${res.message}</div>`;
            
            // Gỡ focus trước khi đóng modal để tránh lỗi aria-hidden
            document.activeElement.blur(); 
            bootstrap.Modal.getInstance(modal).hide();

            modal.addEventListener('hidden.bs.modal', function handler() {
                if (res.errorflag === 'success' && currentRow) currentRow.remove();

                // Nếu Bootstrap của bạn chưa auto gỡ backdrop, giữ lại đoạn này
                document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                document.body.classList.remove('modal-open');
                document.body.style.overflow = 'auto';
                document.body.style.paddingRight = '';

                modal.removeEventListener('hidden.bs.modal', handler);
            });
        })
        .catch(() => {
            messageArea.innerHTML = `<div class="alert alert-danger">Xảy ra lỗi khi xóa!</div>`;
        });
    };

    modal.addEventListener('show.bs.modal', handleShow);
    modal._handlerShow = handleShow;

    modalForm.addEventListener('submit', handleSubmit);
    modalForm._handlerSubmit = handleSubmit;
}

document.addEventListener('DOMContentLoaded', function () {
    bindDeleteModal();
});
