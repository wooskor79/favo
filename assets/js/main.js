// File: app/assets/js/main.js

document.addEventListener('DOMContentLoaded', () => {
    // 다크 모드 토글 스위치
    const themeSwitch = document.getElementById('theme-switch');
    if (themeSwitch) {
        if (localStorage.getItem('theme') === 'dark') {
            themeSwitch.checked = true;
        }
        themeSwitch.addEventListener('change', function(event) {
            if (event.currentTarget.checked) {
                document.documentElement.classList.add('dark-mode');
                localStorage.setItem('theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark-mode');
                localStorage.setItem('theme', 'light');
            }
        });
    }

    // --- 이미지 라이트박스 처리 ---
    const lightbox = document.getElementById('image-lightbox');
    const lightboxImage = document.getElementById('lightbox-image');
    const lightboxClose = document.getElementById('lightbox-close');

    if (lightbox && lightboxImage && lightboxClose) {
        document.body.addEventListener('click', (e) => {
            if (e.target.classList.contains('memo-thumbnail')) {
                lightboxImage.src = e.target.dataset.original;
                lightbox.classList.remove('hidden');
                lightbox.classList.add('flex');
            }
        });

        const closeLightbox = () => {
            lightbox.classList.add('hidden');
            lightbox.classList.remove('flex');
            lightboxImage.src = '';
        };

        lightboxClose.addEventListener('click', closeLightbox);
        lightbox.addEventListener('click', (e) => {
            if (e.target === lightbox) closeLightbox();
        });
    }
});

// 그룹 펼치기/닫기
function openGroup(content, icon) {
    content.style.paddingTop = '1rem';
    content.style.paddingBottom = '1rem';
    content.style.maxHeight = content.scrollHeight + 20 + "px";
    icon.style.transform = 'rotate(180deg)';
    setTimeout(() => content.style.maxHeight = 'none', 300);
}

function closeGroup(content, icon) {
    content.style.maxHeight = content.scrollHeight + "px";
    content.offsetHeight;
    content.style.maxHeight = '0px';
    content.style.paddingTop = '0';
    content.style.paddingBottom = '0';
    icon.style.transform = 'rotate(0deg)';
}

function toggleGroup(headerElement) {
    const content = headerElement.nextElementSibling;
    const icon = headerElement.querySelector('svg');
    if (content.style.maxHeight && content.style.maxHeight !== '0px' && content.style.maxHeight !== 'none') {
        closeGroup(content, icon);
    } else {
        openGroup(content, icon);
    }
}