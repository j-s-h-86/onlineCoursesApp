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

	async function getNewestData() {
		await getCourses();
	}

	async function handleUpdate() {
		if (selectedCourseId) {
			const confirmed = confirm('Är du säker på att du vill uppdatera denna kurs?');
			if (confirmed) {
				try {
					await updateCourse(selectedCourseId, { teacherId, occasions, price });
					alert('Kursen har uppdaterats!');
					resetForm();
					getCourses();
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

<div class="updateCourseDiv">
	<h3>Uppdatera kurs</h3>
	<br />
	<label for="courseId">Välj en kurs att uppdatera:</label><br />
	<select id="courseId" bind:value={selectedCourseId} on:click={getNewestData}>
		<option value="" disabled selected>Välj en kurs...</option>
		{#each $courses as course}
			<option value={course.id}>{course.courseName}</option>
		{/each}
	</select>
	{#if selectedCourseId}
		<div class="courseForm">
			<form on:submit|preventDefault={handleUpdate}>
				<div>
					<label for="teacherId">Lärare (ID):</label><br />
					<input type="number" id="teacherId" bind:value={teacherId} required />
				</div>

				<div>
					<label for="occasions">Antal tillfällen:</label><br />
					<input type="number" id="occasions" bind:value={occasions} required />
				</div>

				<div>
					<label for="price">Pris:</label><br />
					<input type="number" id="price" step="0.01" bind:value={price} required />
				</div>

				<button type="submit">Uppdatera kurs</button>
			</form>
		</div>
	{/if}
</div>

<style>
	.courseForm {
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: space-evenly;
	}
</style>
