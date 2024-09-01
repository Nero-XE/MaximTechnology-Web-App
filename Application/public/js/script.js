document.addEventListener('DOMContentLoaded', function() {
    const progressBar = document.querySelector('progress');
    const duration = 1000; // 1 секунда

    let startTime = Date.now();

    function updateProgress() {
      const elapsedTime = Date.now() - startTime;
      const progress = Math.round((elapsedTime / duration) * 100);

      progressBar.value = progress;

      if (progress < 100) {
        requestAnimationFrame(updateProgress); 
      }
    }

    updateProgress();
});

window.onload = function () {
  var message = document.getElementById('notify');
  if (message) {
      message.classList.add('visible');
      setTimeout(function () {
          message.classList.remove('visible');
      }, 3000);
  }

  var logo = document.getElementById('logo-index');
  if (logo) {
    setTimeout(function () {
      logo.classList.add('visible');
    }, 500);
  }
}

