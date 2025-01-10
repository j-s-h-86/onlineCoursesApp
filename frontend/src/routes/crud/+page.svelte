<script>
	import { onMount } from 'svelte';
	import { user } from '../../lib/stores';
	import { courses } from '../../lib/stores';
	import { teachers } from '../../lib/stores';
	import AddCourse from '$lib/components/forms/AddCourse.svelte';
	import AddTeacher from '$lib/components/forms/AddTeacher.svelte';
	import AddOrder from '$lib/components/forms/AddOrder.svelte';
	import UpdateCourse from '$lib/components/CRUD/UpdateCourse.svelte';
	import DeleteCourse from '$lib/components/CRUD/DeleteCourse.svelte';
	import UpdateTeacher from '$lib/components/CRUD/UpdateTeacher.svelte';
	import DeleteTeacher from '$lib/components/CRUD/DeleteTeacher.svelte';
	import UpdateOrder from '$lib/components/CRUD/UpdateOrder.svelte';
	import DeleteOrder from '$lib/components/CRUD/DeleteOrder.svelte';
	import { getCourses, getOrders } from '$lib/api';

	const baseURL = import.meta.env.VITE_API_BASE_URL;

	const endpoints = [
		{ label: 'Courses', url: `${baseURL}/courses` },
		{ label: 'Teachers', url: `${baseURL}/teachers` },
		{ label: 'Orders', url: `${baseURL}/orders` }
	];

	let selectedEndpoint = null;
	let error = null;

	onMount(async () => {
		try {
			await getTeachers();
			await getCourses();
			await getOrders();
		} catch (err) {
			error = err.message;
		}
	});

	async function logoutFunction() {
		const response = await fetch(`${baseURL}/logout`, {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json'
			}
		});

		const result = await response.json();
		if (result.success) {
			console.log('Logout successful:', result.message);
			user.set(null);
			location.href = '/';
		} else {
			console.error('Logout failed:', result.message);
		}
	}
</script>

<main>
	<h2>Välj en CRUD-endpoint</h2>
	<div class="logoutButton">
		<button on:click={logoutFunction}>Log out</button>
	</div>
	<select bind:value={selectedEndpoint}>
		<option value="" disabled selected>Välj en endpoint...</option>
		{#each endpoints as endpoint}
			<option value={endpoint}>{endpoint.label}</option>
		{/each}
	</select>

	{#if selectedEndpoint && selectedEndpoint.label === 'Courses'}
		<div>
			<AddCourse url={selectedEndpoint.url} />
			<UpdateCourse />
			<DeleteCourse />
		</div>
	{:else if selectedEndpoint && selectedEndpoint.label === 'Teachers'}
		<div>
			<AddTeacher url={selectedEndpoint.url} />
			<UpdateTeacher />
			<DeleteTeacher />
		</div>
	{:else if selectedEndpoint && selectedEndpoint.label === 'Orders'}
		<div>
			<AddOrder url={selectedEndpoint.url} />
			<UpdateOrder />
			<DeleteOrder />
		</div>
	{/if}
	<br />
</main>

<style>
	div {
		display: flex;
		justify-content: space-evenly;
	}

	.logoutButton {
		display: flex;
		justify-content: flex-end;
	}
</style>
