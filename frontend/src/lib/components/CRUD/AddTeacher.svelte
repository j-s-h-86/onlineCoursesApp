<script>
	export let url;

	let teacherName = '';
	let teacherDescription = '';
	let teacherEmail = '';
	let teacherImg = '';

	async function addNewTeacher() {
		const teacherData = {
			teacherName,
			teacherDescription,
			teacherEmail,
			teacherImg
		};

		try {
			const response = await fetch(url, {
				method: 'POST',
				headers: { 'Content-Type': 'application/json' },
				body: JSON.stringify(teacherData)
			});
			const result = await response.json();
			alert(result.message || 'Lärare tillagd!');
			resetForm();
		} catch (error) {
			console.error('Error submitting teacher:', error);
		}
	}

	function resetForm() {
		teacherName = '';
		teacherDescription = '';
		teacherEmail = '';
		teacherImg = '';
	}
</script>

<div class="teacherForm">
	<h3>Lägg till lärare</h3>
	<br />
	<form on:submit|preventDefault={addNewTeacher}>
		<div>
			<label for="teacherName">Lärarnamn:</label><br />
			<input type="text" id="teacherName" bind:value={teacherName} required />
		</div>

		<div>
			<label for="teacherDescription">Beskrivning:</label><br />
			<textarea id="teacherDescription" bind:value={teacherDescription} required></textarea>
		</div>

		<div>
			<label for="teacherEmail">Lärares epost:</label><br />
			<input type="text" id="teacherEmail" bind:value={teacherEmail} required />
		</div>

		<div>
			<label for="teacherImg">Lärarbild:</label><br />
			<input type="text" id="teacherImg" bind:value={teacherImg} required />
		</div>

		<button type="submit">Lägg till lärare</button>
	</form>
</div>

<style>
	.teacherForm {
		display: flex;
		flex-direction: column;
		align-items: flex-start;
		justify-content: space-evenly;
	}
</style>
