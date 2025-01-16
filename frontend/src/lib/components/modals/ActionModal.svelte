<script>
	export let title = '';
	export let message = '';
	export let onConfirm;
	export let onCancel;
</script>

<div class="actionModalBG">
	<div class="actionModal">
		<h2>{title}</h2>
		<p>{message}</p>
		<div class="buttons">
			<button on:click={onConfirm}>Ja</button>
			<button on:click={onCancel}>Nej</button>
		</div>
	</div>
</div>

<style>
	.actionModalBG {
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background: rgba(0, 0, 0, 0.5);
		display: flex;
		justify-content: center;
		align-items: center;
		z-index: 1000;
	}
	.actionModal {
		background-color: #595e61;
		padding: 20px;
		border-radius: 8px;
		box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
		text-align: center;
	}
	.buttons button {
		margin: 10px;
		padding: 10px 20px;
		border: 1px solid black;
		border-radius: 4px;
		cursor: pointer;
		background-color: #3a424a;
		color: #ffb764;
	}
</style>
