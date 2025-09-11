import './bootstrap';

 if (typeof toastr === 'undefined') {
    console.error('Toastr is not defined. Please ensure that the Toastr library is properly included.');
} else {
     toastr.options = {
        closeButton: true,
        debug: false,
        newestOnTop: false,
        progressBar: true,
        positionClass: 'toast-top-right',
        preventDuplicates: true, // Prevents duplicate toasts
        onclick: null,
        showDuration: '300',
        hideDuration: '1000',
        timeOut: '5000',  
        extendedTimeOut: '20000',  
        showEasing: 'swing',
        hideEasing: 'linear',
        showMethod: 'fadeIn',
        hideMethod: 'fadeOut'
    };

     console.log('Toastr options:', toastr.options);

     window.Echo.channel('my-channel')
        .listen('.form-submitted', (data) => {
             if (!data || !data.post) {
                console.error('Received data is undefined or does not contain expected post information:', data);
                return;
            }

             const audioElement = document.getElementById('notificationAudio');
            if (audioElement) {
                 audioElement.play().then(() => {
                    console.log('Notification sound played successfully.');
                }).catch(error => {
                    console.error('Audio playback failed:', error);
                    exit;
                });
            } else {
                console.error('Notification audio element not found.'); exit;
            }

             toastr.success(`Type : ${data.post.type}<br> TransactionId : ${data.post.transaction_id}<br>Amount: ${data.post.amount}<br>Currency: ${data.post.Currency}<br>Status: ${data.post.status}`, `${data.post.msg}`);
        });
}
