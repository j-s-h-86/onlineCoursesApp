<script>
	import { onMount } from 'svelte';
	import { teachers } from '$lib/stores';
	import { getTeachers, deleteTeacher } from '$lib/api';
	import ActionModal from '$lib/components/modals/ActionModal.svelte';

	let showActionModal = false;
	let actionModalOptions = {};
	let selectedTeacherId = '';

	onMount(async () => {
		await getTeachers();
	});

	async function handleDelete() {
		if (selectedTeacherId) {
			actionModalOptions = {
				title: 'Bekräfta borttagning',
				message: 'Är du säker på att du vill ta bort denna lärare?',
				onConfirm: async () => {
					showActionModal = false;
					await deleteTeacher(selectedTeacherId);
					resetForm();
					getTeachers();
				},
				onCancel: () => {
					showActionModal = false;
				}
			};
			showActionModal = true;
		} else {
			actionModalOptions = {
				title: 'Fel',
				message: 'Vänligen välj en lärare att ta bort',
				onConfirm: () => {
					showActionModal = false;
				},
				onCancel: null
			};
			showActionModal = true;
		}
	}

	function resetForm() {
		selectedTeacherId = '';
	}
</script>

<div>
	<h3>Ta bort lärare</h3>
	<br />
	<label for="teacherId">Välj en lärare att ta bort:</label><br />
	<select id="teacherId" bind:value={selectedTeacherId}>
		<option value="" disabled selected>Välj en lärare...</option>
		{#each $teachers as teacher}
			<option value={teacher.id}>{teacher.teacherName}</option>
		{/each}
	</select>
	<br />
	<button on:click={handleDelete}>Ta bort lärare</button>
</div>

{#if showActionModal}
	<ActionModal
		title={actionModalOptions.title}
		message={actionModalOptions.message}
		onConfirm={actionModalOptions.onConfirm}
		onCancel={actionModalOptions.onCancel}
	/>
{/if}
