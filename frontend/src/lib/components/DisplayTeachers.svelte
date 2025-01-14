<script>
	import { teachers } from '$lib/stores';
</script>

<h2>Våra lärare</h2>
{#if $teachers.length > 0}
	<div class="onlineTeachers">
		{#each $teachers as teacher}
			<div class="teacher">
				<h3>{teacher.name}</h3>
				<div class="teacherImgContainer">
					<img src={teacher.img} alt="teacher" />
				</div>
				<div>
					<p><b>Information:</b></p>
					<p>{teacher.description}</p>
				</div>
			</div>
		{/each}
	</div>
{:else}
	<p>Inga lärare anställda just nu.</p>
{/if}

<style>
	h2 {
		color: #ffb764;
	}

	.onlineTeachers {
		width: 100%;
		display: flex;
		flex-wrap: wrap;
		justify-content: space-evenly;
	}

	.teacher {
		display: flex;
		flex-direction: column;
		justify-content: space-evenly;
		text-align: center;
		height: 400px;
		width: 350px;
		border: 1px solid black;
		border-radius: 10%;
		background-color: #595e61;
		margin: 20px;
	}

	.teacherImgContainer {
		height: 200px;
		width: auto;
	}

	img {
		height: 100%;
		width: auto;
	}
</style>
