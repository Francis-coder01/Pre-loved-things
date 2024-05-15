const uploadSection = document.querySelector('section.item-image-uploads')
const imageAdder = document.querySelector('.image-upload-adder')

let lastLoadedImageId = 0;
let allImagesAreLoaded = false
const maxImageNumber = 7;

if(imageAdder){
    imageAdder.addEventListener('click', () => {
        if (allImagesAreLoaded){
            uploadSection.insertBefore(createImageUploader(), imageAdder)
            allImagesAreLoaded = false
        }
        if (lastLoadedImageId+1 === maxImageNumber) {
            imageAdder.style.display = "none";
        }
    })
}

function onchangeHandler() {
    previewImage(this.id);
}
function previewImage(imageId) {
    const fileUploadInput = document.querySelector('.uploader#' + imageId)
    const imagePreviewer = fileUploadInput.parentElement
    if (!fileUploadInput.value) {
        return;
    }
    const image = fileUploadInput.files[0]

    if (!image.type.includes('image')) {
        return alert('Only images are allowed!')
    }

    if (image.size > 1_000_000) {
        fileUploadInput.value = ''
        return alert('Maximum upload size is 1MB!')
    }
    const addPhotoIcon = imagePreviewer.querySelector('i')
    imagePreviewer.removeChild(addPhotoIcon)

    const fileReader = new FileReader()
    fileReader.readAsDataURL(image)

    fileReader.onload = (fileReaderEvent) => {
        imagePreviewer.style.backgroundImage = `url(${fileReaderEvent.target.result})`
    }
    const id = parseInt(imageId.substring(3))
    if(id > lastLoadedImageId) lastLoadedImageId = id
    allImagesAreLoaded = true
    const removeButton = createRemoveButton(id);
    if(removeButton !== null) {
        fileUploadInput.parentNode.appendChild(removeButton)
        fileUploadInput.parentElement.draggable = true;
    }
}

function createRemoveButton(id) {
    if(document.querySelector('i#delete' + id) !== null) return null;
    const removeButton = document.createElement('i')
    removeButton.classList.add('material-symbols-outlined')
    removeButton.classList.add('bolder')
    removeButton.classList.add('delete-icon')
    removeButton.innerText = 'delete'
    removeButton.id = "delete" + id
    removeButton.addEventListener('click', shiftImages.bind(removeButton))

    return removeButton
}

function shiftImages() {
    imageAdder.style.display = "block"
    const removedId = parseInt(this.id.substring(6))
    const fileUploadInputToRemove = document.querySelector('.uploader#img' + removedId)
    if(lastLoadedImageId === 1){
        fileUploadInputToRemove.value = ''
        fileUploadInputToRemove.parentElement.style.backgroundImage = ''
        fileUploadInputToRemove.parentElement.draggable = false
        fileUploadInputToRemove.parentElement.removeChild(fileUploadInputToRemove.parentElement.querySelector('i'))
        fileUploadInputToRemove.parentElement.insertBefore(createAddPhotoIcon(),fileUploadInputToRemove.parentElement.querySelector('input'))
        lastLoadedImageId = 0
        if(allImagesAreLoaded === false){
            const uploadDivs = uploadSection.querySelectorAll('div.photo-upload')
            uploadSection.removeChild(uploadDivs[uploadDivs.length-1])
        }
        allImagesAreLoaded = false
        return
    }

    uploadSection.removeChild(fileUploadInputToRemove.parentNode)

    for (let i = removedId + 1; i <= lastLoadedImageId; i++) {
        const fileUploadInputToShift = document.querySelector('.uploader#img' + i)
        const removeButtonToShift = fileUploadInputToShift.parentNode.querySelector('#delete' + i)
        fileUploadInputToShift.id = fileUploadInputToShift.name = "img" + (i-1)
        removeButtonToShift.id = 'delete' + (i-1)
    }
    lastLoadedImageId--

    if(removedId === 1){
        const mainImageHeader = document.createElement('h5')
        mainImageHeader.innerText = 'Main Image'
        const mainImageDiv = document.querySelector('.uploader#img1').parentElement
        mainImageDiv.classList.add('main-photo-upload')
        mainImageDiv.insertBefore(mainImageHeader, mainImageDiv.querySelector('.uploader'))
    }
}

function createAddPhotoIcon() {
    const addPhotoIcon = document.createElement('i')
    addPhotoIcon.classList.add('material-symbols-outlined')
    addPhotoIcon.classList.add('bolder')
    addPhotoIcon.classList.add('upload-icon')
    addPhotoIcon.innerText = 'add_a_photo'
    return addPhotoIcon;
}

function createImageUploader() {
    const uploadDiv = document.createElement('div')
    uploadDiv.classList.add('photo-upload')
    uploadDiv.addEventListener('dragstart', handleDragStart);
    uploadDiv.addEventListener('dragover', handleDragOver);
    uploadDiv.addEventListener('dragenter', handleDragEnter);
    uploadDiv.addEventListener('dragleave', handleDragLeave);
    uploadDiv.addEventListener('dragend', handleDragEnd);
    uploadDiv.addEventListener('drop', handleDrop);

    const addPhotoIcon = createAddPhotoIcon();

    let uploaderInput = document.createElement('input')
    uploaderInput.type = 'file'
    uploaderInput.name = uploaderInput.id = 'img' + (lastLoadedImageId+1) //changed
    uploaderInput.classList.add('uploader')
    uploaderInput.accept = 'image/*'
    uploaderInput.onchange = this.onchangeHandler;

    uploadDiv.appendChild(addPhotoIcon)
    uploadDiv.appendChild(uploaderInput)

    return uploadDiv
}


uploadSection.querySelectorAll('div.photo-upload').forEach(m => {
    m.addEventListener('dragstart', handleDragStart);
    m.addEventListener('dragover', handleDragOver);
    m.addEventListener('dragenter', handleDragEnter);
    m.addEventListener('dragleave', handleDragLeave);
    m.addEventListener('dragend', handleDragEnd);
    m.addEventListener('drop', handleDrop);
})

let dragSrcEl;

function handleDragStart(e) {
    this.style.opacity = '0.2';
    dragSrcEl = this;
    e.dataTransfer.effectAllowed = 'move';
    e.dataTransfer.setData('text/inputID', this.querySelector('.uploader').id);
    e.dataTransfer.setData('text/inputName', this.querySelector('.uploader').name);
    e.dataTransfer.setData('text/deleteID', this.querySelector('.delete-icon').id);
    e.dataTransfer.setData('text/class', this.className);
}

function handleDragEnd(e) {
    this.style.opacity = '0.75';
    let uploadDivs = uploadSection.querySelectorAll('div.photo-upload')
    uploadDivs.forEach(function (item) {
        item.classList.remove('over');
    });
}

function handleDragOver(e) {
    e.preventDefault();
    return false;
}

function handleDragEnter(e) {
    this.classList.add('over');
}

function handleDragLeave(e) {
    this.classList.remove('over');
}

function handleDrop(e) {
    e.stopPropagation(); // stops the browser from redirecting.
    if (dragSrcEl !== this && this.draggable) {
        dragSrcEl.querySelector('.uploader').id = this.querySelector('.uploader').id;
        dragSrcEl.querySelector('.uploader').name = this.querySelector('.uploader').name;
        dragSrcEl.querySelector('.delete-icon').id = this.querySelector('.delete-icon').id;
        dragSrcEl.className = this.className;

        this.querySelector('.uploader').id = e.dataTransfer.getData('text/inputID');
        this.querySelector('.uploader').name = e.dataTransfer.getData('text/inputName');
        this.querySelector('.delete-icon').id = e.dataTransfer.getData('text/deleteID');
        this.className = e.dataTransfer.getData('text/class');

        if (this.querySelector('h5')) {
            dragSrcEl.appendChild(this.querySelector('h5'));
        } else if (dragSrcEl.querySelector('h5')) {
            this.appendChild(dragSrcEl.querySelector('h5'));
        }

        for(let i = 1; i <= lastLoadedImageId; i++) {
            this.parentElement.appendChild(this.parentElement.querySelector('#img' + i).parentElement);
        }

        if (!this.parentElement.querySelector('.photo-upload').draggable) {
            this.parentElement.appendChild(this.parentElement.querySelector('.photo-upload'));
        }
        this.parentElement.appendChild(this.parentElement.querySelector('.image-upload-adder'));
    }
    return false;
}