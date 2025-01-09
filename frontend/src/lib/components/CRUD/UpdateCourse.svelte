<script>
	import { onMount } from 'svelte';
	import { courses } from '$lib/stores';
	import { getCourses, updateCourse } from '$lib/api';

	let selectedCourseId = '';
	let teacherId = '';
	let occasions = '';
	let price = '';

	onMount(async () => {
		await getCourses();
	});

	async function handleUpdate() {
		if (selectedCourseId) {
			const confirmed = confirm('Är du säker på att du vill uppdatera denna kurs?');
			if (confirmed) {
				try {
					await updateCourse(selectedCourseId, { teacherId, occasions, price });
					alert('Kursen har uppdaterats!');
					resetForm();
				} catch (error) {
					console.error(error);
					alert('Det gick inte att uppdatera kursen.');
				}
			}
		} else {
			alert('Vänligen välj en kurs att uppdatera');
		}
	}

	function resetForm() {
		selectedCourseId = '';
		teacherId = '';
		occasions = '';
		price = '';
	}
</script>

<div>
	<label for="courseId">Välj en kurs att uppdatera:</label>
	<select id="courseId" bind:value={selectedCourseId}>
		<option value="" disabled selected>Välj en kurs...</option>
		{#each $courses as course}
			<option value={course.id}>{course.courseName}</option>
		{/each}
	</select>
</div>

{#if selectedCourseId}
	<div class="courseForm">
		<form on:submit|preventDefault={handleUpdate}>
			<div>
				<label for="teacherId">Lärare (ID):</label>
				<input type="number" id="teacherId" bind:value={teacherId} required />
			</div>

			<div>
				<label for="occasions">Antal tillfällen:</label>
				<input type="number" id="occasions" bind:value={occasions} required />
			</div>

			<div>
				<label for="price">Pris:</label>
				<input type="number" id="price" step="0.01" bind:value={price} required />
			</div>

			<button type="submit">Uppdatera kurs</button>
		</form>
	</div>
{/if}
