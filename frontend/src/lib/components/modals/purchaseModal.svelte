<script>
	import { onMount } from 'svelte';
	import { modalStates } from '$lib/stores';

	const baseURL = import.meta.env.VITE_API_BASE_URL;
	const stripeKey = import.meta.env.VITE_SPK;

	export let selectedCourse;

	let dialog;
	let fullName = '';
	let email = '';
	let courseId = selectedCourse?.id || '';
	let price = selectedCourse?.price || '';
	let stripe;

	onMount(() => {
		const stripePublicKey = import.meta.env.VITE_STRIPE_PUBLIC_KEY;
		if (!stripePublicKey) {
			console.error('Stripe public key is not defined');
			return;
		}
		stripe = Stripe(stripePublicKey);
	});

	$: if (dialog) {
		console.log('Dialog element found');
		if ($modalStates.purchaseModal) {
			dialog.showModal();
		} else {
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

	async function handlePurchase(fullName, email, courseId, price) {
		try {
			const sessionResponse = await fetch(`${baseURL}/create-checkout-session`, {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json'
				},
				body: JSON.stringify({
					fullName,
					email,
					courseId,
					price
				})
			});

			const session = await sessionResponse.json();

			if (!sessionResponse.ok) {
				throw new Error('Failed to create Stripe Checkout session');
			}
			const result = await stripe.redirectToCheckout({
				sessionId: session.id
			});

			if (result.error) {
				console.error(result.error.message);
			}
		} catch (error) {
			console.error('Failed to place order:', error);
		}
	}

	async function handleSubmit(event) {
		event.preventDefault();
		const newOrder = { fullName, email, courseId, price };
		await handlePurchase(fullName, email, courseId, price);
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
		background-color: #595e61;
	}

	dialog::backdrop {
		background: rgba(0, 0, 0, 0.8);
	}

	button {
		color: #ffb764;
	}
</style>
