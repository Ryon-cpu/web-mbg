const mobileMenuButton = document.getElementById('mobile-menu-btn');
const mobileMenu = document.getElementById('mobile-menu');

if (mobileMenuButton && mobileMenu) {
	mobileMenuButton.addEventListener('click', () => {
		mobileMenu.classList.toggle('hidden');
	});
}
