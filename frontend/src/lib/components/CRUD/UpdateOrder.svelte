<script>
	import { onMount } from 'svelte';
	import { orders, courses } from '$lib/stores';
	import { getOrders, updateOrder } from '$lib/api';

	let selectedOrderId = '';
	let orderId = '';
	let fullName = '';
	let email = '';
	let courseId = '';
	let price = '';

	onMount(async () => {
		await getOrders();
	});

	async function handleUpdate() {
		if (selectedOrderId) {
			const confirmed = confirm('Är du säker på att du vill uppdatera denna order?');
			if (confirmed) {
				try {
					await updateOrder(selectedOrderId, {
						fullName,
						email,
						courseId,
						price
					});
					alert('Order har uppdaterats!');
					resetForm();
				} catch (error) {
					console.error(error);
					alert('Det gick inte att uppdatera ordern.');
				}
			}
		} else {
			alert('Vänligen välj en order att uppdatera');
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
	<select id="orderId" bind:value={selectedOrderId}>
		<option value="" disabled selected>Välj en order...</option>
		{#each $orders as order}
			<option value={order.id}>{order.id}</option>
		{/each}
	</select>
	{#if selectedOrderId}
		<div class="orderForm">
			<form on:submit|preventDefault={handleUpdate}>
				<div>
					<label for="fullName">Namn:</label><br />
					<input type="text" id="fullName" bind:value={fullName} required />
				</div>
				<div>
					<label for="email">Epost:</label><br />
					<input type="email" id="email" bind:value={email} required />
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
					<input type="number" id="price" bind:value={price} required />
				</div>

				<button type="submit">Uppdatera order</button>
			</form>
		</div>
	{/if}
</div>

<style>
	.orderForm {
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: space-evenly;
	}
</style>
