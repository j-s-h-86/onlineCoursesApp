<div class="startPage">
	<div class="heroImg">
		<img src="/webbkurs.jpg" alt="webbkursbild" />
		<a href="/courses" class="notButton">Titta på våra kurser!</a>
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
		right: 10%;
		transform: translate(-50%, -50%);
		background-color: rgba(44, 43, 43, 0.7);
		color: white;
		padding: 10px 20px;
		text-decoration: none;
		font-size: 1.2rem;
		border-radius: 5px;
		text-align: center;
	}

	@media (max-width: 768px) {
		.startPage {
			height: 100vh;
		}
		.heroImg {
			width: 100%;
			height: auto;
			position: relative;
			display: inline-block;
		}

		.notButton {
			height: 50px;
			width: 100px;
			position: fixed;
			top: 40%;
			right: 1%;
			transform: translate(-50%, -50%);
			font-size: 0.7rem;
		}
	}
</style>
