<script>
	import { modalStates } from '$lib/stores';

	export let selectedCourse;

	let dialog;

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
</script>

<dialog bind:this={dialog} on:close={closeModal}>
	<slot name="header" />
	<hr />
	<div>
		<p><b>Kurs:</b> {selectedCourse?.name}</p>
		<p><b>Beskrivning:</b> {selectedCourse?.description}</p>
		<p><b>Pris:</b> {selectedCourse?.price} SEK</p>
	</div>
	<hr />
	<button on:click={closeModal} aria-label="Close the modal">Close</button>
</dialog>

<style>
	dialog {
		border: none;
		padding: 0;
		width: 50%;
		max-width: 500px;
		margin: auto;
		top: 20%;
		position: fixed;
		z-index: 1000;
	}

	dialog::backdrop {
		background: rgba(0, 0, 0, 0.8);
	}
</style>
