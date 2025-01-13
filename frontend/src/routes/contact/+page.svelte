<script>
	import PostMessage from '$lib/components/PostMessage.svelte';
</script>

<div>
	<PostMessage />
	<br />
	<br />
	<p>
		Vi ser fram emot att höra ifrån dig! <br />
		Dessvärre sparas ditt meddelande i en databas och går inte alls till någon inkorg. <br />
		Chansen att någon fiskar upp det och återkommer till dig är därför ganska liten. <br />
		Men tack för att du hör av dig!
	</p>
</div>

<style>
	div {
		height: 100%;
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: center;
	}
</style>
