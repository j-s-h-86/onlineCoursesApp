<script>
	import DeleteTeacher from '../CRUD/DeleteTeacher.svelte';

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
			alert(result.message || 'Teacher added successfully!');
		} catch (error) {
			console.error('Error submitting teacher:', error);
		}
	}
</script>

<form on:submit|preventDefault={addNewTeacher}>
	<div>
		<label for="teacherName">Lärarnamn:</label>
		<input type="text" id="teacherName" bind:value={teacherName} required />
	</div>

	<div>
		<label for="teacherDescription">Beskrivning:</label>
		<textarea id="teacherDescription" bind:value={teacherDescription} required></textarea>
	</div>

	<div>
		<label for="teacherEmail">Lärares epost:</label>
		<input type="text" id="teacherEmail" bind:value={teacherEmail} required />
	</div>

	<div>
		<label for="teacherImg">Lärarbild:</label>
		<input type="text" id="teacherImg" bind:value={teacherImg} required />
	</div>

	<button type="submit">Lägg till lärare</button>
</form>
<DeleteTeacher />
