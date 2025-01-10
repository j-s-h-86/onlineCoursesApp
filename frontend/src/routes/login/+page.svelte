<script>
	import Login from '$lib/components/Login.svelte';
	import { user } from '$lib/stores';
</script>

<div>
	<h2>Admin login</h2>
	<Login />
</div>

<style>
	div {
		height: 100vh;
	}
</style>
