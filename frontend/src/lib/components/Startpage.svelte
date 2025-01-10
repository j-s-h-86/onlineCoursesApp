<div class="startPage">
	<div class="heroImg">
		<img src="/webbkurs.jpg" alt="webbkursbild" />
		<a href="/courses" class="notButton">Ta reda på hur!</a>
	</div>
</div>

<style>
	.startPage {
		display: flex;
		justify-content: center;
	}

	.heroImg {
		width: 70%;
		height: auto;
		position: relative;
		display: inline-block;
	}

	.heroImg img {
		display: block;
		width: 100%;
		height: auto;
		border-radius: 5px;
	}

	.notButton {
		height: 60px;
		width: 150px;
		position: absolute;
		top: 40%;
		right: 5%;
		transform: translate(-50%, -50%);
		background-color: rgba(44, 43, 43, 0.7);
		color: white;
		padding: 10px 20px;
		text-decoration: none;
		font-size: 1.2rem;
		border-radius: 5px;
		text-align: center;
	}
</style>
