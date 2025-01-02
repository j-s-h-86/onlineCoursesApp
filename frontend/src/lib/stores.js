import { writable } from 'svelte/store';

export const courses = writable([]);
export const teachers = writable([]);

export const modalStates = writable({
	purchaseModal: false
});

modalStates.subscribe((value) => {
	console.log('modalStates updated:', value);
});

export const user = writable(null);
