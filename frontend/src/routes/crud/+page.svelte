<script>
	import { user } from '../../lib/stores';

	const baseURL = import.meta.env.VITE_API_BASE_URL;

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

<h1>CRUD</h1>

<button on:click={logoutFunction}>Log out</button>
