<script>
	import { onMount } from 'svelte';
	import { courses } from '$lib/stores';
	import { deleteCourse, getCourses } from '$lib/api';
	import ActionModal from '$lib/components/modals/ActionModal.svelte';

	let showActionModal = false;
	let actionModalOptions = {};

	let selectedCourseId = '';

	onMount(async () => {
		await getCourses();
	});

	async function handleDelete() {
		if (selectedCourseId) {
			actionModalOptions = {
				title: 'Bekräfta borttagning',
				message: 'Är du säker på att du vill radera denna kurs?',
				onConfirm: async () => {
					showActionModal = false;
					await deleteCourse(selectedCourseId);
					resetForm();
					getCourses();
				},
				onCancel: () => {
					showActionModal = false;
				}
			};
			showActionModal = true;
		} else {
			actionModalOptions = {
				title: 'Fel',
				message: 'Vänligen välj en kurs att radera',
				onConfirm: () => {
					showActionModal = false;
				},
				onCancel: null
			};
			showActionModal = true;
		}
	}

	function resetForm() {
		selectedCourseId = '';
	}
</script>

<div>
	<h3>Ta bort kurs</h3>
	<br />
	<label for="courseId">Välj en kurs att radera:</label><br />
	<select id="courseId" bind:value={selectedCourseId}>
		<option value="" disabled selected>Välj en kurs...</option>
		{#each $courses as course}
			<option value={course.id}>{course.courseName}</option>
		{/each}
	</select>
	<br />
	<button on:click={handleDelete}>Radera kurs</button>
</div>

{#if showActionModal}
	<ActionModal
		title={actionModalOptions.title}
		message={actionModalOptions.message}
		onConfirm={actionModalOptions.onConfirm}
		onCancel={actionModalOptions.onCancel}
	/>
{/if}
