<script>
	import { onMount } from 'svelte';
	import { orders } from '$lib/stores';
	import { deleteOrder, getOrders } from '$lib/api';
	import ActionModal from '$lib/components/modals/ActionModal.svelte';

	let showActionModal = false;
	let actionModalOptions = {};
	let selectedOrderId = '';

	onMount(async () => {
		await getOrders();
	});

	async function handleDelete() {
		if (selectedOrderId) {
			actionModalOptions = {
				title: 'Bekräfta borttagning',
				message: 'Är du säker på att du vill radera denna order?',
				onConfirm: async () => {
					showActionModal = false;
					await deleteOrder(selectedOrderId);
					resetForm();
					getOrders();
				},
				onCancel: () => {
					showActionModal = false;
				}
			};
			showActionModal = true;
		} else {
			actionModalOptions = {
				title: 'Fel',
				message: 'Vänligen välj en order att radera',
				onConfirm: () => {
					showActionModal = false;
				},
				onCancel: null
			};
			showActionModal = true;
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

{#if showActionModal}
	<ActionModal
		title={actionModalOptions.title}
		message={actionModalOptions.message}
		onConfirm={actionModalOptions.onConfirm}
		onCancel={actionModalOptions.onCancel}
	/>
{/if}

<style>
</style>
