<script>
	import { onMount } from 'svelte';
	import { orders } from '$lib/stores';
	import { deleteOrder, getOrders } from '$lib/api';

	let selectedOrderId = '';

	onMount(async () => {
		await getOrders();
	});

	async function handleDelete() {
		if (selectedOrderId) {
			const confirmed = confirm('Är du säker på att du vill radera denna order?');
			if (confirmed) {
				await deleteOrder(selectedOrderId);
				resetForm();
				getOrders();
			}
		} else {
			alert('Vänligen välj en order att radera');
		}
	}

	function resetForm() {
		selectedOrderId = '';
	}
</script>

<div>
	<h3>Ta bort order</h3>
	<br />
	<label for="orderId">Välj en order att radera:</label><br />
	<select id="orderId" bind:value={selectedOrderId}>
		<option value="" disabled selected>Välj en order...</option>
		{#each $orders as order}
			<option value={order.id}>{order.id}</option>
		{/each}
	</select>
	<br />
	<button on:click={handleDelete}>Radera order</button>
</div>

<style>
</style>
