document.addEventListener('DOMContentLoaded', () => {
	const sidebar = document.getElementById('admin-sidebar');
	const toggleBtn = document.getElementById('toggle-sidebar-btn');
	const closeBtn = document.getElementById('close-sidebar-btn');
	const backdrop = document.getElementById('sidebar-backdrop');

	function isMobile() {
		return window.innerWidth < 768;
	}

	function openSidebar() {
		if (isMobile()) {
			sidebar.classList.add('mobile-open');
			backdrop.classList.remove('hidden');
			requestAnimationFrame(() => {
				backdrop.classList.remove('opacity-0');
				backdrop.classList.add('opacity-100');
			});
			document.body.classList.add('overflow-hidden');
		}
	}

	function closeSidebar() {
		sidebar.classList.remove('mobile-open');
		backdrop.classList.remove('opacity-100');
		backdrop.classList.add('opacity-0');
		setTimeout(() => {
			backdrop.classList.add('hidden');
		}, 300);
		document.body.classList.remove('overflow-hidden');
	}

	if (toggleBtn) {
		toggleBtn.addEventListener('click', (event) => {
			event.stopPropagation();
			if (sidebar.classList.contains('mobile-open')) {
				closeSidebar();
			} else {
				openSidebar();
			}
		});
	}

	if (closeBtn) {
		closeBtn.addEventListener('click', closeSidebar);
	}

	if (backdrop) {
		backdrop.addEventListener('click', closeSidebar);
	}

	document.addEventListener('keydown', (event) => {
		if (event.key === 'Escape' && sidebar.classList.contains('mobile-open')) {
			closeSidebar();
		}
	});

	window.addEventListener('resize', () => {
		if (!isMobile()) {
			closeSidebar();
		}
	});
});
