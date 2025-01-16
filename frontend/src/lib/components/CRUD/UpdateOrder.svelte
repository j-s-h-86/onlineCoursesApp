<script>
	import { onMount } from 'svelte';
	import { orders, courses } from '$lib/stores';
	import { getOrders, updateOrder } from '$lib/api';
	import ActionModal from '$lib/components/modals/ActionModal.svelte';

	let showActionModal = false;
	let actionModalOptions = {};
	let selectedOrderId = '';
	let selectedOrder = null;
	let orderId = '';
	let fullName = '';
	let email = '';
	let courseId = '';
	let price = '';

	onMount(async () => {
		await getOrders();
	});

	async function getNewestData() {
		await getOrders();
	}

	$: if (selectedOrderId) {
		selectedOrder = $orders.find((order) => order.id === selectedOrderId);
	} else {
		selectedOrder = null;
	}

	async function handleUpdate() {
		if (selectedOrderId) {
			actionModalOptions = {
				title: 'Bekräfta uppdatering',
				message: 'Är du säker på att du vill uppdatera denna order?',
				onConfirm: async () => {
					showActionModal = false;
					await updateOrder(selectedOrderId, {
						fullName,
						email,
						courseId,
						price
					});
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
				message: 'Vänligen välj en order att uppdatera',
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
		fullName = '';
		email = '';
		courseId = '';
		price = '';
	}
</script>

<div>
	<h3>Uppdatera en order</h3>
	<br />
	<label for="orderId">Välj en order att uppdatera:</label><br />
	<select id="orderId" bind:value={selectedOrderId} on:click={getNewestData}>
		<option value="" disabled selected>Välj en order...</option>
		{#each $orders as order}
			<option value={order.id}>{order.id}</option>
		{/each}
	</select>
	{#if selectedOrder}
		<div class="orderForm">
			<form on:submit|preventDefault={handleUpdate}>
				<div>
					<label for="fullName">Namn:</label><br />
					<input
						type="text"
						id="fullName"
						bind:value={fullName}
						placeholder={selectedOrder.fullName || ''}
						required
					/>
				</div>
				<div>
					<label for="email">Epost:</label><br />
					<input
						type="email"
						id="email"
						bind:value={email}
						placeholder={selectedOrder.email || ''}
						required
					/>
				</div>

				<div>
					<label for="courseId">Kurs:</label><br />
					<select id="courseId" bind:value={courseId}>
						<option value="" disabled selected>Välj en kurs...</option>
						{#each $courses as course}
							<option value={course.id}>{course.courseName}</option>
						{/each}
					</select>
				</div>

				<div>
					<label for="price">Pris:</label><br />
					<input
						type="number"
						id="price"
						bind:value={price}
						placeholder={selectedOrder.price || ''}
						required
					/>
				</div>

				<button type="submit">Uppdatera order</button>
			</form>
		</div>
	{/if}
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
	.orderForm {
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: space-evenly;
	}
</style>
