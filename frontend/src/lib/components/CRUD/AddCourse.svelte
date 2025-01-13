<script>
	export let url;

	let courseName = '';
	let courseDescription = '';
	let teacherId = '';
	let occasions = '';
	let price = '';

	async function addNewCourse() {
		const courseData = {
			courseName,
			courseDescription,
			teacherId: parseInt(teacherId),
			occasions: parseInt(occasions),
			price: parseFloat(price)
		};

		try {
			const response = await fetch(url, {
				method: 'POST',
				headers: { 'Content-Type': 'application/json' },
				body: JSON.stringify(courseData)
			});
			const result = await response.json();
			alert(result.message || 'Kurs tillagd!');
			resetForm();
		} catch (error) {
			console.error('Error submitting course:', error);
		}
	}

	function resetForm() {
		courseName = '';
		courseDescription = '';
		teacherId = '';
		occasions = '';
		price = '';
	}
</script>

<div class="courseForm">
	<h3>Skapa kurs</h3>
	<br />
	<form on:submit|preventDefault={addNewCourse}>
		<div>
			<label for="courseName">Kursnamn:</label><br />
			<input type="text" id="courseName" bind:value={courseName} required />
		</div>

		<div>
			<label for="courseDescription">Beskrivning:</label><br />
			<textarea id="courseDescription" bind:value={courseDescription} required></textarea>
		</div>

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

		<button type="submit">Lägg till kurs</button>
	</form>
</div>

<style>
	.courseForm {
		display: flex;
		flex-direction: column;
		align-items: flex-start;
		justify-content: space-evenly;
	}
</style>
