import './bootstrap';

var channel = Echo.channel('my-channel');
channel.listen('.my-event', function(data) {
  alert(JSON.stringify(data));
});

if (typeof toastr === 'undefined') {
    alert('Toastr is not defined. Please ensure that the Toastr library is properly included.');
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
        if (!data) {
            console.error('Received data is undefined:', data);
            return;
        }

        const audioElement = document.getElementById('notificationAudio');
        if (audioElement) {
            audioElement.play().then(() => {
                console.log('Notification sound played successfully.');
            }).catch(error => {
                console.error('Audio playback failed:', error);
            });
        } else {
            console.error('Notification audio element not found.');
        }

        toastr.success(
            `Type : ${data.type}<br> TransactionId : ${data.transaction_id}<br>Amount: ${data.amount}<br>Currency: ${data.Currency}<br>Status: ${data.status}`,
            `${data.msg}`
        );
    });

}