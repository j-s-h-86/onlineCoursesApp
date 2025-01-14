import { writable } from 'svelte/store';

export const courses = writable([]);
export const teachers = writable([]);
export const orders = writable([]);
export const messages = writable([]);

export const modalStates = writable({
	purchaseModal: false,
	messageModal: false
});

modalStates.subscribe((value) => {
	console.log('modalStates updated:', value);
});

export const user = writable(null);
