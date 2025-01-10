import { courses } from './stores';
import { teachers } from './stores';
import { orders } from './stores';

const baseURL = import.meta.env.VITE_API_BASE_URL;

export async function getCourses() {
	const response = await fetch(`${baseURL}/courses`);
	if (!response.ok) {
		throw new Error(`Error fetching courses: ${response.statusText}`);
	}
	const data = await response.json();
	courses.set(data);
}

export async function getCourseById(id) {
	if (!id) {
		throw new Error('Course ID is required');
	}
	const response = await fetch(`${baseURL}/courses?id=${id}`);
	if (!response.ok) {
		throw new Error(`Error fetching course with ID ${id}: ${response.statusText}`);
	}
	const data = await response.json();
	return data;
}

export async function updateCourse(id, updatedData) {
	const response = await fetch(`${baseURL}/courses/${id}`, {
		method: 'PUT',
		headers: {
			'Content-Type': 'application/json'
		},
		body: JSON.stringify(updatedData)
	});

	if (!response.ok) {
		throw new Error(`Failed to update course: ${response.statusText}`);
	}

	return await response.json();
}

export async function deleteCourse(id) {
	const response = await fetch(`${baseURL}/courses/${id}`, {
		method: 'DELETE',
		headers: {
			'Content-Type': 'application/json'
		}
	});

	if (!response.ok) {
		console.error(`Error deleting course: ${response.statusText}`);
		throw new Error(`Error deleting course: ${response.statusText}`);
	}

	const result = await response.json();
	console.log('Delete course result:', result);

	if (result.message === 'Course deleted successfully') {
		alert('Kursen har raderats!');
	} else {
		console.error('Error: Course not deleted', result);
		alert('Det gick inte att radera kursen');
	}
}

export async function getTeachers() {
	const response = await fetch(`${baseURL}/teachers`);
	if (!response.ok) {
		throw new Error(`Error fetching teachers: ${response.statusText}`);
	}
	const data = await response.json();
	teachers.set(data);
}

export async function getTeacherById(id) {
	if (!id) {
		throw new Error('Teacher ID is required');
	}
	const response = await fetch(`${baseURL}/teachers?id=${id}`);
	if (!response.ok) {
		throw new Error(`Error fetching teacher with ID ${id}: ${response.statusText}`);
	}
	const data = await response.json();
	return data;
}

export async function updateTeacher(id, updatedData) {
	const response = await fetch(`${baseURL}/teachers/${id}`, {
		method: 'PUT',
		headers: {
			'Content-Type': 'application/json'
		},
		body: JSON.stringify(updatedData)
	});

	if (!response.ok) {
		throw new Error(`Failed to update teacher: ${response.statusText}`);
	}

	return await response.json();
}

export async function deleteTeacher(id) {
	const response = await fetch(`${baseURL}/teachers/${id}`, {
		method: 'DELETE',
		headers: {
			'Content-Type': 'application/json'
		}
	});

	if (!response.ok) {
		console.error(`Error deleting teacher: ${response.statusText}`);
		throw new Error(`Error deleting teacher: ${response.statusText}`);
	}

	const result = await response.json();
	console.log('Delete teacher result:', result);

	if (result.message === 'Teacher deleted successfully') {
		alert('Coachen har tagits bort!');
	} else {
		console.error('Error: Teacher not deleted', result);
		alert('Det gick inte att radera coachen');
	}
}

export async function getOrders() {
	const response = await fetch(`${baseURL}/orders`);
	if (!response.ok) {
		throw new Error(`Error fetching orders: ${response.statusText}`);
	}
	const data = await response.json();
	console.log(data);

	orders.set(data);
}

export async function getOrderById(id) {
	if (!id) {
		throw new Error('Order ID is required');
	}
	const response = await fetch(`${baseURL}/orders/${id}`);
	if (!response.ok) {
		throw new Error(`Error fetching order with ID ${id}: ${response.statusText}`);
	}
	const data = await response.json();
	return data;
}

export async function updateOrder(id, updatedData) {
	const response = await fetch(`${baseURL}/orders/${id}`, {
		method: 'PUT',
		headers: {
			'Content-Type': 'application/json'
		},
		body: JSON.stringify(updatedData)
	});

	if (!response.ok) {
		throw new Error(`Failed to update order: ${response.statusText}`);
	}

	return await response.json();
}

export async function deleteOrder(id) {
	const response = await fetch(`${baseURL}/orders/${id}`, {
		method: 'DELETE',
		headers: {
			'Content-Type': 'application/json'
		}
	});

	if (!response.ok) {
		console.error(`Error deleting order: ${response.statusText}`);
		throw new Error(`Error deleting order: ${response.statusText}`);
	}

	const result = await response.json();
	console.log('Delete order result:', result);

	if (result.message === 'Order removed successfully') {
		alert('Ordern har raderats!');
	} else {
		console.error('Error: Order not deleted', result);
		alert('Det gick inte att radera ordern');
	}
}
