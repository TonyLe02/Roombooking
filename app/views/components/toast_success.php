<!-- Toast Component -->
<div id='toast-success' class='text-base semibold fixed bottom-5 left-1/2 transform -translate-x-1/2 bg-white z-auto px-4 py-2 rounded shadow-lg flex items-center space-x-2'>
    <i class='text-green-500 fas fa-check-circle'></i>
    <span><?php echo $toastMessage; ?></span>
</div>
<script>
    setTimeout(() => {
        const successToast = document.getElementById('toast-success');
        if (successToast) {
            successToast.style.transition = 'opacity 0.5s ease';
            successToast.style.opacity = '0';
            setTimeout(() => successToast.remove(), 500);
        }
    }, 3000);
</script>