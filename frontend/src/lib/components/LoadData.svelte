<script>
	import { onMount } from 'svelte';
	import { get } from 'svelte/store';
	import { courses, teachers } from '$lib/stores';
	import { getCourses, getTeachers } from '$lib/api';
	import DisplayCourses from './DisplayCourses.svelte';

	let orders = [];
	let error = null;

	onMount(async () => {
		try {
			await getTeachers();
			const teachersData = get(teachers);

			const mappedTeachers = teachersData.map((teacher) => {
				return {
					id: teacher.id,
					name: teacher.teacherName,
					description: teacher.teacherDescription,
					email: teacher.teacherEmail,
					img: teacher.teacherImg
				};
			});

			const teacherMap = mappedTeachers.reduce((map, teacher) => {
				map[teacher.id] = teacher.name;
				return map;
			}, {});

			await getCourses();
			const coursesData = get(courses);
			console.log('Courses Data:', coursesData);

			const mappedCourses = coursesData.map((course) => {
				return {
					id: course.id,
					name: course.courseName,
					description: course.courseDescription,
					teacherName: teacherMap[course.teacherId] || 'Unknown',
					occasions: course.occasions,
					price: course.price
				};
			});

			courses.set(mappedCourses);
			console.log('Courses set in store:', mappedCourses);
			teachers.set(mappedTeachers);
			console.log(mappedTeachers);
		} catch (err) {
			error = err.message;
		}
	});
</script>

{#if error}
	<p>Error: {error}</p>
{/if}
