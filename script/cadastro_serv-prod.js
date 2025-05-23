const tabs = document.querySelectorAll('.tab-btn');
const contents = document.querySelectorAll('.tab-content');

tabs.forEach(tab => {
  tab.addEventListener('click', () => {
    tabs.forEach(btn => btn.classList.remove('active'));
    tab.classList.add('active');

    contents.forEach(content => {
      content.classList.remove('active');
      if (content.id === tab.dataset.tab) {
        content.classList.add('active');
      }
    });
  });
});
