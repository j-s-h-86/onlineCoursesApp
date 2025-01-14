<script>
	import Header from '$lib/components/layout/Header.svelte';
	import Footer from '$lib/components/layout/Footer.svelte';
</script>

<Header />
<main>
	<div class="appWrap">
		<slot />
	</div>
</main>
<Footer />

<style>
	.appWrap {
		text-align: center;
		width: 100%;
		padding: 20px;
	}
	main {
		background-color: #3a424a;
		padding: 10px;
		min-height: 100%;
	}
</style>
