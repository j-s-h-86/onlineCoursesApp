<script>
	import { user } from '$lib/stores';

	const baseURL = import.meta.env.VITE_API_BASE_URL;

	let email = '';
	let password = '';

	async function loginUser() {
		const response = await fetch(`${baseURL}/login`, {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json'
			},
			body: JSON.stringify({
				email: email,
				password: password
			})
		});

		const result = await response.json();
		if (result.success) {
			location.href = '/crud';
			console.log('Login successful:', result.message);
		} else {
			console.error('Login failed:', result.message);
		}
	}

	function handleSubmit(event) {
		event.preventDefault();
		loginUser();
	}
</script>

<form on:submit={handleSubmit}>
	<label for="email">Email</label><br />
	<input type="email" id="email" bind:value={email} required />
	<br />
	<br />
	<label for="password">Password</label><br />
	<input type="password" id="password" bind:value={password} required />
	<br />
	<br />
	<button type="submit">Login</button>
</form>

<style>
	button {
		color: #ffb764;
	}
</style>
