<script>
	const baseURL = import.meta.env.VITE_API_BASE_URL;

	let fullName = '';
	let email = '';
	let message = '';

	async function addNewMessage() {
		const messageData = {
			fullName,
			email,
			message
		};

		try {
			const response = await fetch(`${baseURL}/messages`, {
				method: 'POST',
				headers: { 'Content-Type': 'application/json' },
				body: JSON.stringify(messageData)
			});
			const result = await response.json();
			resetForm();
			alert(result.message || 'Message added successfully!');
		} catch (error) {
			console.error('Error submitting message:', error);
		}
	}

	function resetForm() {
		fullName = '';
		email = '';
		message = '';
	}
</script>

<div class="messageForm">
	<h3>Skicka ett meddelande till oss</h3>
	<br />
	<form on:submit|preventDefault={addNewMessage}>
		<div>
			<label for="fullName">Namn:</label><br />
			<input type="text" id="fullName" bind:value={fullName} required />
		</div>

		<div>
			<label for="email">Epost:</label><br />
			<input type="email" id="email" bind:value={email} required />
		</div>

		<div>
			<label for="message">Ditt meddelande:</label><br />
			<textarea id="message" bind:value={message} required></textarea>
		</div>

		<button type="submit">Skicka meddelande</button>
	</form>
</div>

<style>
	.messageForm {
		display: flex;
		flex-direction: column;
		align-items: flex-start;
		justify-content: space-evenly;
	}
</style>
