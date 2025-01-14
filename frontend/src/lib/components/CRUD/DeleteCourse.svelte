<script>
	import { onMount } from 'svelte';
	import { courses } from '$lib/stores';
	import { deleteCourse, getCourses } from '$lib/api';

	let selectedCourseId = '';

	onMount(async () => {
		await getCourses();
	});

	async function handleDelete() {
		if (selectedCourseId) {
			const confirmed = confirm('Är du säker på att du vill radera denna kurs?');
			if (confirmed) {
				await deleteCourse(selectedCourseId);
				resetForm();
				getCourses();
			}
		} else {
			alert('Vänligen välj en kurs att radera');
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
