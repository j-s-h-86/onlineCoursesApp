<script>
	import { onMount } from 'svelte';
	import { get } from 'svelte/store';
	import { teachers } from '$lib/stores';
	import { getTeachers, deleteTeacher } from '$lib/api';

	let selectedTeacherId = '';

	onMount(async () => {
		await getTeachers();
	});

	async function handleDelete() {
		if (selectedTeacherId) {
			const confirmed = confirm('Är du säker på att du vill ta bort denna lärare?');
			if (confirmed) {
				await deleteTeacher(selectedTeacherId);
			}
		} else {
			alert('Vänligen välj en lärare att radera');
		}
	}
</script>

<div>
	<label for="teacherId">Välj en lärare att ta bort:</label>
	<select id="teacherId" bind:value={selectedTeacherId}>
		<option value="" disabled selected>Välj en lärare...</option>
		{#each $teachers as teacher}
			<option value={teacher.id}>{teacher.teacherName}</option>
		{/each}
	</select>
</div>

<button on:click={handleDelete}>Ta bort lärare</button>
