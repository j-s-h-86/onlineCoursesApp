<script>
	import { onMount } from 'svelte';
	import { get } from 'svelte/store';
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
			}
		} else {
			alert('Vänligen välj en kurs att radera');
		}
	}
</script>

<div>
	<label for="courseId">Välj en kurs att radera:</label>
	<select id="courseId" bind:value={selectedCourseId}>
		<option value="" disabled selected>Välj en kurs...</option>
		{#each $courses as course}
			<option value={course.id}>{course.courseName}</option>
		{/each}
	</select>
</div>

<button on:click={handleDelete}>Radera kurs</button>
