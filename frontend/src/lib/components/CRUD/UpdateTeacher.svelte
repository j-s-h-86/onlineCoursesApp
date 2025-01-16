<script>
	import { onMount } from 'svelte';
	import { teachers } from '$lib/stores';
	import { getTeachers, updateTeacher } from '$lib/api';
	import ActionModal from '$lib/components/modals/ActionModal.svelte';

	let showActionModal = false;
	let actionModalOptions = {};
	let selectedTeacherId = '';
	let teacherId = '';
	let teacherName = '';
	let teacherDescription = '';
	let teacherEmail = '';
	let teacherImg = '';

	onMount(async () => {
		await getTeachers();
	});

	async function getNewestData() {
		await getTeachers();
	}

	async function handleUpdate() {
		if (selectedTeacherId) {
			actionModalOptions = {
				title: 'Bekräfta uppdatering',
				message: 'Är du säker på att du vill uppdatera denna lärare?',
				onConfirm: async () => {
					showActionModal = false;
					await updateTeacher(selectedTeacherId, {
						teacherName,
						teacherDescription,
						teacherEmail,
						teacherImg
					});
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
				message: 'Vänligen välj en lärare att uppdatera',
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
		teacherName = '';
		teacherDescription = '';
		teacherEmail = '';
		teacherImg = '';
	}
</script>

<div>
	<h3>Uppdatera en lärare</h3>
	<br />
	<label for="teacherId">Välj en lärare att uppdatera:</label><br />
	<select id="teacherId" bind:value={selectedTeacherId} on:click={getNewestData}>
		<option value="" disabled selected>Välj en lärare...</option>
		{#each $teachers as teacher}
			<option value={teacher.id}>{teacher.teacherName}</option>
		{/each}
	</select>
	{#if selectedTeacherId}
		<div class="teacherForm">
			<form on:submit|preventDefault={handleUpdate}>
				<div>
					<label for="teacherName">Lärarnamn:</label><br />
					<input type="text" id="teacherName" bind:value={teacherName} required />
				</div>
				<div>
					<label for="teacherDescription">Lärarinfo:</label><br />
					<input type="text" id="teacherDescription" bind:value={teacherDescription} required />
				</div>

				<div>
					<label for="teacherEmail">Lärares epost:</label><br />
					<input type="email" id="teacherEmail" bind:value={teacherEmail} required />
				</div>

				<div>
					<label for="teacherImg">Bild:</label><br />
					<input type="text" id="teacherImg" bind:value={teacherImg} required />
				</div>

				<button type="submit">Uppdatera lärare</button>
			</form>
		</div>
	{/if}
</div>

{#if showActionModal}
	<ActionModal
		title={actionModalOptions.title}
		message={actionModalOptions.message}
		onConfirm={actionModalOptions.onConfirm}
		onCancel={actionModalOptions.onCancel}
	/>
{/if}

<style>
	.teacherForm {
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: space-evenly;
	}
</style>
