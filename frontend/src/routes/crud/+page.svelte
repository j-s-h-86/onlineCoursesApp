<script>
	import { onMount } from 'svelte';
	import { user } from '../../lib/stores';
	import { courses } from '../../lib/stores';
	import { teachers } from '../../lib/stores';

	const baseURL = import.meta.env.VITE_API_BASE_URL;
	const endpoints = [
		{ label: 'Courses', url: `${baseURL}/courses` },
		{ label: 'Teachers', url: `${baseURL}/teachers` },
		{ label: 'Orders', url: `${baseURL}/orders` }
	];

	let selectedEndpoint = null;
	let postData = '';
	let responseMessage = '';

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

	async function postToEndpoint() {
		if (!selectedEndpoint || !postData) {
			alert('Välj en endpoint och skriv in data att skicka!');
			return;
		}

		try {
			const response = await fetch(selectedEndpoint.url, {
				method: 'POST',
				headers: { 'Content-Type': 'application/json' },
				body: postData
			});
			const result = await response.json();
			responseMessage = JSON.stringify(result, null, 2);
		} catch (error) {
			console.error('Error posting to endpoint:', error);
			responseMessage = 'Ett fel inträffade.';
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

	<textarea
		bind:value={postData}
		placeholder="Skriv JSON-data att skicka"
		rows="5"
		style="width: 100%; margin-top: 10px;"
	></textarea>

	<button on:click={postToEndpoint} style="margin-top: 10px;">Skicka</button>

	{#if responseMessage}
		<h2>Svar från servern:</h2>
		<pre>{responseMessage}</pre>
	{/if}
	<br />
	<button on:click={logoutFunction}>Log out</button>
</main>
