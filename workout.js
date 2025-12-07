// Modal logic for showing YouTube video
document.addEventListener('DOMContentLoaded', function() {
    const bodyParts = document.querySelectorAll('.body-part');
    const modal = document.getElementById('video-modal');
    const closeBtn = document.querySelector('.modal .close');
    const youtubeIframe = document.getElementById('youtube-video');

    bodyParts.forEach(part => {
        part.addEventListener('click', function() {
            const videoUrl = this.getAttribute('data-video');
            youtubeIframe.src = videoUrl + '?autoplay=1';
            modal.style.display = 'flex';
        });
    });

    closeBtn.addEventListener('click', function() {
        modal.style.display = 'none';
        youtubeIframe.src = '';
    });

    // Close modal when clicking outside video
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.style.display = 'none';
            youtubeIframe.src = '';
        }
    });
});