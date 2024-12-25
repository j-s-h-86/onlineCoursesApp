<script>
	import { modalStates } from '$lib/stores';
	import { postOrder } from '$lib/api';

	export let selectedCourse;

	let dialog;
	let fullName = '';
	let email = '';
	let courseId = selectedCourse?.id || '';

	$: if (dialog) {
		console.log('Dialog element found');
		if ($modalStates.purchaseModal) {
			console.log('Showing modal');
			dialog.showModal();
		} else {
			console.log('Hiding modal');
			dialog.close();
		}
	}

	function closeModal() {
		modalStates.update((state) => ({
			...state,
			purchaseModal: false
		}));
		dialog.close();
	}

	async function handlePurchase(fullName, email, courseId) {
		try {
			const result = await postOrder(fullName, email, courseId);
			console.log('Order placed successfully:', result);
		} catch (error) {
			console.error('Failed to place order:', error);
		}
	}

	async function handleSubmit(event) {
		event.preventDefault();
		const newOrder = { fullName, email, courseId };
		console.log('Form data:', newOrder);

		await handlePurchase(fullName, email, courseId);

		closeModal();
	}
</script>

<dialog bind:this={dialog} on:close={closeModal}>
	<slot name="header" />
	<hr />
	<h2>{selectedCourse?.name}</h2>
	<form on:submit={handleSubmit}>
		<div>
			<p><b>Beskrivning:</b> {selectedCourse?.description}</p>
			<p><b>Pris:</b> {selectedCourse?.price} SEK</p>
		</div>
		<hr />
		<div>
			<label for="name">Namn:</label>
			<input type="text" id="name" bind:value={fullName} required />
		</div>
		<div>
			<label for="email">E-post:</label>
			<input type="email" id="email" bind:value={email} required />
		</div>
		<input type="hidden" bind:value={courseId} />
		<hr />
		<button type="submit">Skicka</button>
		<button on:click={closeModal} aria-label="Close the modal">Close</button>
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
	}

	dialog::backdrop {
		background: rgba(0, 0, 0, 0.8);
	}
</style>
