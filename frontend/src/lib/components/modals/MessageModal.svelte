<script>
	import { onMount } from 'svelte';
	import { modalStates } from '$lib/stores';

	const baseURL = import.meta.env.VITE_API_BASE_URL;

	export let selectedTeacher;

	let dialog;
	let fullName = '';
	let email = '';
	let subject = '';
	let message = '';
	let recipient = selectedTeacher?.name || '';

	async function addNewMessage() {
		const messageData = {
			fullName,
			email,
			recipient,
			subject,
			message
		};

		try {
			const response = await fetch(`${baseURL}/messages`, {
				method: 'POST',
				headers: { 'Content-Type': 'application/json' },
				body: JSON.stringify(messageData)
			});
			const result = await response.json();
			alert(result.message || 'Message added successfully!');
			resetForm();
			closeModal();
		} catch (error) {
			console.error('Error submitting message:', error);
		}
	}

	function resetForm() {
		fullName = '';
		email = '';
		recipient = '';
		subject = '';
		message = '';
	}

	$: if (dialog) {
		console.log('Dialog element found');
		if ($modalStates.messageModal) {
			dialog.showModal();
		} else {
			dialog.close();
		}
	}

	function closeModal() {
		modalStates.update((state) => ({
			...state,
			messageModal: false
		}));
		dialog.close();
	}
</script>

<dialog bind:this={dialog} on:close={closeModal}>
	<slot name="header" />
	<h3>Meddelande till {selectedTeacher?.name}</h3>
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
			<label for="subject">Ämne:</label><br />
			<input type="subject" id="subject" bind:value={subject} required />
		</div>

		<div>
			<label for="message">Ditt meddelande:</label><br />
			<textarea id="message" bind:value={message} required></textarea>
		</div>
		<input type="hidden" bind:value={recipient} />
		<button type="submit">Skicka meddelande</button>
		<button on:click={closeModal} aria-label="Close the modal">Stäng</button>
	</form>
</dialog>

<style>
	dialog {
		border-radius: 10px;
		padding: 10;
		width: 400px;
		height: 500px;
		margin-bottom: 20px;
		top: 20%;
		position: fixed;
		z-index: 1000;
		background-color: #595e61;
	}

	dialog::backdrop {
		background: rgba(0, 0, 0, 0.8);
	}

	button {
		color: #ffb764;
	}
</style>
