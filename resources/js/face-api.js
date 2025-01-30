import * as faceapi from 'face-api.js';

async function setupFaceApi() {
    const MODEL_URL = '/models'; // Lokasi model yang disimpan di public
    await faceapi.nets.ssdMobilenetv1.loadFromUri(MODEL_URL);
    await faceapi.nets.faceLandmark68Net.loadFromUri(MODEL_URL);
    await faceapi.nets.faceRecognitionNet.loadFromUri(MODEL_URL);
}

async function handleFaceDetection(videoElement) {
    const detections = await faceapi.detectAllFaces(videoElement)
        .withFaceLandmarks()
        .withFaceDescriptors();

    if (detections.length > 0) {
        const descriptors = detections.map(d => d.descriptor);
        return descriptors;
    }

    return null;
}

export { setupFaceApi, handleFaceDetection };
