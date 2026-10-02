document.addEventListener('DOMContentLoaded', () => {
	const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
	const dateInput = document.getElementById('tanggal');
	const dayText = document.getElementById('hari-text');
	const addRowButton = document.getElementById('add-row-btn');
	const itemsBody = document.getElementById('items-body');
	const itemsTable = document.getElementById('items-table');
	const nutrientFields = ['energi', 'protein', 'lemak', 'karbo', 'serat'];
	let rowIndex = Number(itemsTable.dataset.rowIndex);

	function updateDayDisplay() {
		if (!dateInput.value) {
			return;
		}

		const date = new Date(`${dateInput.value}T00:00:00`);
		const formattedDate = dateInput.value.split('-').reverse().join('/');
		dayText.textContent = `Hari ${days[date.getDay()]}, ${formattedDate}`;
	}

	function recalcTotals() {
		const totals = { energi: 0, protein: 0, lemak: 0, karbo: 0, serat: 0 };

		itemsBody.querySelectorAll('tr').forEach((row) => {
			nutrientFields.forEach((field) => {
				const input = row.querySelector(`input[name*="[${field}]"]`);
				if (input) {
					totals[field] += parseFloat(input.value || 0);
				}
			});
		});

		nutrientFields.forEach((field) => {
			document.getElementById(`total-${field}`).textContent = totals[field].toFixed(1);
		});
	}

	function bindDeleteAndInput(row) {
		row.querySelector('.delete-row-btn').addEventListener('click', () => {
			if (itemsBody.querySelectorAll('tr').length <= 1) {
				alert('Minimal harus ada 1 item makanan.');
				return;
			}

			row.remove();
			recalcTotals();
		});

		row.querySelectorAll('input[type="number"]').forEach((input) => {
			input.addEventListener('input', recalcTotals);
		});
	}

	if (dateInput) {
		dateInput.addEventListener('change', updateDayDisplay);
		updateDayDisplay();
	}

	if (addRowButton) {
		addRowButton.addEventListener('click', () => {
			const index = rowIndex++;
			const row = document.createElement('tr');
			row.className = 'item-row border-b border-slate-50';
			row.dataset.index = index;
			row.innerHTML = `
				<td class="px-4 py-2.5">
					<input type="text" name="items[${index}][nama_item]" placeholder="Nama makanan..." required
						   class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500 text-xs">
				</td>
				<td class="px-3 py-2.5">
					<input type="text" name="items[${index}][takaran]" placeholder="100 g" required
						   class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500 text-xs">
				</td>
				${nutrientFields.map((field) => `
				<td class="px-3 py-2.5 text-center">
					<input type="number" name="items[${index}][${field}]" placeholder="0" value="0" min="0" step="0.001" required
						   class="w-full px-2 py-2 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500 text-xs text-center">
				</td>`).join('')}
				<td class="px-3 py-2.5 text-center">
					<button type="button" class="delete-row-btn p-1.5 rounded-lg text-slate-300 hover:text-rose-500 hover:bg-rose-50 transition" title="Hapus baris">
						<i class="fa-solid fa-trash text-xs"></i>
					</button>
				</td>
			`;

			itemsBody.appendChild(row);
			row.querySelector('input').focus();
			bindDeleteAndInput(row);
			recalcTotals();
		});
	}

	itemsBody.querySelectorAll('tr').forEach(bindDeleteAndInput);
	recalcTotals();
});
