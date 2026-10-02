document.addEventListener('DOMContentLoaded', () => {
	let cropper = null;

	const fotoInput = document.getElementById('foto-input');
	const cropImage = document.getElementById('crop-image');
	const modal = document.getElementById('crop-modal');
	const modalClose = document.getElementById('modal-close-btn');
	const croppedInput = document.getElementById('cropped-image-input');
	const profileForm = document.getElementById('profile-form');
	const saveBtn = document.getElementById('save-btn');
	const currentAvatar = document.getElementById('current-avatar');
	const changePhotoBtn = document.getElementById('change-photo-btn');
	const deletePhotoForm = document.getElementById('delete-photo-form');

	function openModal() {
		modal.classList.add('open');
		document.body.style.overflow = 'hidden';
	}

	function closeModal() {
		modal.classList.remove('open');
		document.body.style.overflow = '';

		if (cropper) {
			cropper.destroy();
			cropper = null;
		}

		fotoInput.value = '';
		saveBtn.disabled = false;
		saveBtn.innerHTML = '<i class="fa-solid fa-floppy-disk text-base"></i> Simpan Foto Profil';
	}

	function setupCropper(imageSrc) {
		openModal();

		if (cropper) {
			cropper.destroy();
			cropper = null;
		}

		cropImage.src = imageSrc;

		setTimeout(() => {
			cropper = new Cropper(cropImage, {
				aspectRatio: 1,
				viewMode: 1,
				dragMode: 'move',
				autoCropArea: 0.85,
				responsive: true,
				restore: false,
				checkCrossOrigin: false,
				checkOrientation: false,
				guides: true,
				center: true,
				highlight: false,
				cropBoxMovable: true,
				cropBoxResizable: true,
				toggleDragModeOnDblclick: false,
				preview: ['#preview-circle', '#preview-circle-sm'],
				ready: () => cropper.crop(),
			});
		}, 80);
	}

	function handlePhotoChange(event) {
		const file = event.target.files[0];
		if (!file) {
			return;
		}

		if (file.size > 5 * 1024 * 1024) {
			alert('Ukuran file melebihi 5MB. Silakan pilih foto yang lebih kecil.');
			fotoInput.value = '';
			return;
		}

		const validTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg', 'image/pjpeg'];
		const validExtensions = ['.jpg', '.jpeg', '.png', '.webp'];
		const fileName = file.name.toLowerCase();
		const isExtensionValid = validExtensions.some((extension) => fileName.endsWith(extension));

		if (!validTypes.includes(file.type.toLowerCase()) && !isExtensionValid) {
			alert('Format tidak didukung. Gunakan JPEG, PNG, atau WebP.');
			fotoInput.value = '';
			return;
		}

		const reader = new FileReader();
		reader.onload = (event) => setupCropper(event.target.result);
		reader.readAsDataURL(file);
	}

	function submitCroppedPhoto(event) {
		event.preventDefault();

		if (!cropper) {
			alert('Belum ada foto yang dipilih atau crop belum siap.');
			return;
		}

		saveBtn.disabled = true;
		saveBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>&nbsp; Menyimpan...';

		try {
			let canvas;

			try {
				canvas = cropper.getCroppedCanvas({
					width: 400,
					height: 400,
					imageSmoothingEnabled: true,
					imageSmoothingQuality: 'high',
				});
			} catch (error) {
				console.warn('getCroppedCanvas dengan dimensi gagal:', error);
			}

			if (!canvas) {
				try {
					canvas = cropper.getCroppedCanvas();
				} catch (error) {
					console.warn('getCroppedCanvas standar gagal:', error);
				}
			}

			if (!canvas) {
				const data = cropper.getData(true);
				canvas = document.createElement('canvas');
				canvas.width = 400;
				canvas.height = 400;
				const context = canvas.getContext('2d');
				context.imageSmoothingEnabled = true;
				context.imageSmoothingQuality = 'high';
				const sourceX = Math.max(0, data.x || 0);
				const sourceY = Math.max(0, data.y || 0);
				const sourceWidth = data.width || cropImage.naturalWidth || 400;
				const sourceHeight = data.height || cropImage.naturalHeight || 400;
				context.drawImage(cropImage, sourceX, sourceY, sourceWidth, sourceHeight, 0, 0, 400, 400);
			}

			const base64Data = canvas.toDataURL('image/jpeg', 0.92);
			if (!base64Data.startsWith('data:image/jpeg;base64,')) {
				throw new Error('Format gambar tidak valid.');
			}

			croppedInput.value = base64Data;
			HTMLFormElement.prototype.submit.call(profileForm);
		} catch (error) {
			console.error(error);
			alert(`Gagal memproses foto: ${error.message || 'Terjadi kesalahan sistem.'}`);
			saveBtn.disabled = false;
			saveBtn.innerHTML = '<i class="fa-solid fa-floppy-disk text-base"></i> Simpan Foto Profil';
		}
	}

	document.querySelectorAll('[data-cropper-action]').forEach((button) => {
		button.addEventListener('click', () => {
			if (!cropper) {
				return;
			}

			const action = button.dataset.cropperAction;
			if (action === 'zoom-in') cropper.zoom(0.1);
			if (action === 'zoom-out') cropper.zoom(-0.1);
			if (action === 'rotate-left') cropper.rotate(-45);
			if (action === 'rotate-right') cropper.rotate(45);
			if (action === 'reset') cropper.reset();
			if (action === 'replace') fotoInput.click();
		});
	});

	if (changePhotoBtn) changePhotoBtn.addEventListener('click', () => fotoInput.click());
	if (fotoInput) fotoInput.addEventListener('change', handlePhotoChange);
	if (modal) modal.addEventListener('click', (event) => {
		if (event.target === modal) closeModal();
	});
	if (modalClose) modalClose.addEventListener('click', closeModal);
	if (profileForm) profileForm.addEventListener('submit', submitCroppedPhoto);
	if (currentAvatar) currentAvatar.addEventListener('error', () => {
		currentAvatar.style.display = 'none';
		currentAvatar.nextElementSibling.classList.remove('hidden');
		currentAvatar.nextElementSibling.classList.add('flex');
	});
	if (deletePhotoForm) deletePhotoForm.addEventListener('submit', (event) => {
		if (!confirm('Apakah Anda yakin ingin menghapus foto profil dan kembali ke avatar inisial?')) {
			event.preventDefault();
		}
	});
	document.addEventListener('keydown', (event) => {
		if (event.key === 'Escape' && modal.classList.contains('open')) closeModal();
	});
});
