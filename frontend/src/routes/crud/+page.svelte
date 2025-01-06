<script>
	import { onMount } from 'svelte';
	import { user } from '../../lib/stores';
	import { courses } from '../../lib/stores';
	import { teachers } from '../../lib/stores';
	import CourseForm from '$lib/components/forms/CourseForm.svelte';
	import TeacherForm from '$lib/components/forms/TeacherForm.svelte';
	import OrderForm from '$lib/components/forms/OrderForm.svelte';

	const baseURL = import.meta.env.VITE_API_BASE_URL;

	const endpoints = [
		{ label: 'Courses', url: `${baseURL}/courses` },
		{ label: 'Teachers', url: `${baseURL}/teachers` },
		{ label: 'Orders', url: `${baseURL}/orders` }
	];

	let selectedEndpoint = null;

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
	<h1>Välj en CRUD-endpoint</h1>
	<select bind:value={selectedEndpoint}>
		<option value="" disabled selected>Välj en endpoint...</option>
		{#each endpoints as endpoint}
			<option value={endpoint}>{endpoint.label}</option>
		{/each}
	</select>

	{#if selectedEndpoint && selectedEndpoint.label === 'Courses'}
		<CourseForm url={selectedEndpoint.url} />
	{:else if selectedEndpoint && selectedEndpoint.label === 'Teachers'}
		<TeacherForm url={selectedEndpoint.url} />
	{:else if selectedEndpoint && selectedEndpoint.label === 'Orders'}
		<OrderForm url={selectedEndpoint.url} />
	{/if}
	<br />
	<button on:click={logoutFunction}>Log out</button>
</main>
