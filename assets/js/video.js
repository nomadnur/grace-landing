document.addEventListener('DOMContentLoaded', () => {
  console.log('✅ video.js loaded and DOMContentLoaded fired');

  document.querySelectorAll('.video-wrapper[data-youtube-id]').forEach(wrapper => {
    console.log('🔍 wiring up wrapper:', wrapper);
    const playBtn = wrapper.querySelector('.video-poster__play');
    const iframeContainer = wrapper.querySelector('.video-iframe');
    const ytID = wrapper.dataset.youtubeId;
    console.log('   – YouTube ID:', ytID);

    if (!playBtn || !ytID) {
      console.warn('   – Missing play button or YouTube ID, skipping');
      return;
    }

    playBtn.addEventListener('click', () => {
      console.log('▶️ play button clicked — injecting iframe');
      const iframe = document.createElement('iframe');
      iframe.src = `https://www.youtube.com/embed/${ytID}?rel=0&modestbranding=1&autoplay=1&controls=1`;
      iframe.title = wrapper.getAttribute('aria-label') || 'Video';
      iframe.frameBorder = '0';
      iframe.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture';
      iframe.allowFullscreen = true;
      iframe.loading = 'lazy';

      iframeContainer.appendChild(iframe);
      iframeContainer.setAttribute('aria-hidden', 'false');
      wrapper.querySelector('.video-poster').style.display = 'none';
    });
  });
});