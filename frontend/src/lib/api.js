const baseURL = import.meta.env.VITE_API_BASE_URL;

export async function getCourses() {
	const response = await fetch(`${baseURL}/courses`);
	if (!response.ok) {
		throw new Error(`Error fetching courses: ${response.statusText}`);
	}
	const data = await response.json();
	return data;
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

export async function getTeachers() {
	const response = await fetch(`${baseURL}/teachers`);
	if (!response.ok) {
		throw new Error(`Error fetching teachers: ${response.statusText}`);
	}
	const data = await response.json();
	return data;
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

export async function getOrders() {
	const response = await fetch(`${baseURL}/orders`);
	if (!response.ok) {
		throw new Error(`Error fetching orders: ${response.statusText}`);
	}
	const data = await response.json();
	return data;
}

export async function getOrderById(id) {
	if (!id) {
		throw new Error('Order ID is required');
	}
	const response = await fetch(`${baseURL}/orders?id=${id}`);
	if (!response.ok) {
		throw new Error(`Error fetching order with ID ${id}: ${response.statusText}`);
	}
	const data = await response.json();
	return data;
}

export async function postOrder(fullName, email, courseId, price) {
	try {
		const response = await fetch(`${baseURL}/orders`, {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json'
			},
			body: JSON.stringify({ fullName, email, courseId, price })
		});
		if (!response.ok) {
			throw new Error('Network response was not ok');
		}
		const result = await response.json();
		return result;
	} catch (error) {
		console.error('Error placing order:', error);
		throw error;
	}
}
