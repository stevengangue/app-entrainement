<div class="media-uploader">
    <div class="upload-area" id="uploadArea">
        <input type="file" id="fileInput" class="d-none" accept="image/*,video/*">
        <div class="upload-icon">
            <i class="fas fa-cloud-upload-alt fa-3x"></i>
        </div>
        <h5>Glissez-déposez vos fichiers ici</h5>
        <p class="text-muted">ou cliquez pour sélectionner</p>
        <small class="text-muted">Formats acceptés: JPG, PNG, GIF, MP4 (max 100MB)</small>
    </div>
    
    <div id="uploadProgress" class="mt-3 d-none">
        <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 0%"></div>
        </div>
        <p class="text-center mt-2">Upload en cours...</p>
    </div>
    
    <div id="uploadPreview" class="mt-3"></div>
</div>

@push('scripts')
<script>
    const uploadArea = document.getElementById('uploadArea');
    const fileInput = document.getElementById('fileInput');
    const uploadProgress = document.getElementById('uploadProgress');
    const uploadPreview = document.getElementById('uploadPreview');
    
    uploadArea.addEventListener('click', () => fileInput.click());
    
    uploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadArea.classList.add('drag-over');
    });
    
    uploadArea.addEventListener('dragleave', () => {
        uploadArea.classList.remove('drag-over');
    });
    
    uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadArea.classList.remove('drag-over');
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            uploadFile(files[0]);
        }
    });
    
    fileInput.addEventListener('change', (e) => {
        if (e.target.files.length > 0) {
            uploadFile(e.target.files[0]);
        }
    });
    
    function uploadFile(file) {
        const formData = new FormData();
        formData.append('file', file);
        
        uploadProgress.classList.remove('d-none');
        uploadPreview.innerHTML = '';
        
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '/api/upload', true);
        xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
        
        xhr.upload.addEventListener('progress', (e) => {
            if (e.lengthComputable) {
                const percentComplete = (e.loaded / e.total) * 100;
                const progressBar = uploadProgress.querySelector('.progress-bar');
                progressBar.style.width = percentComplete + '%';
            }
        });
        
        xhr.onload = function() {
            uploadProgress.classList.add('d-none');
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                showPreview(response.path, file.type);
                showNotification('success', 'Fichier téléchargé avec succès !');
            } else {
                showNotification('error', 'Erreur lors du téléchargement');
            }
        };
        
        xhr.send(formData);
    }
    
    function showPreview(path, fileType) {
        const preview = document.createElement('div');
        preview.className = 'preview-item';
        
        if (fileType.startsWith('image/')) {
            preview.innerHTML = `
                <img src="${path}" class="img-fluid rounded" style="max-height: 200px;">
                <button class="btn btn-danger btn-sm mt-2" onclick="deleteFile('${path}')">
                    <i class="fas fa-trash"></i> Supprimer
                </button>
            `;
        } else if (fileType.startsWith('video/')) {
            preview.innerHTML = `
                <video controls class="img-fluid rounded" style="max-height: 200px;">
                    <source src="${path}" type="video/mp4">
                </video>
                <button class="btn btn-danger btn-sm mt-2" onclick="deleteFile('${path}')">
                    <i class="fas fa-trash"></i> Supprimer
                </button>
            `;
        }
        
        uploadPreview.appendChild(preview);
    }
    
    function deleteFile(path) {
        if (confirm('Êtes-vous sûr de vouloir supprimer ce fichier ?')) {
            fetch('/api/delete-media', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ path: path })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    uploadPreview.innerHTML = '';
                    showNotification('success', 'Fichier supprimé avec succès');
                }
            });
        }
    }
    
    function showNotification(type, message) {
        // Implémenter les notifications toast
        const toast = document.createElement('div');
        toast.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 end-0 m-3`;
        toast.style.zIndex = 9999;
        toast.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    }
</script>

<style>
    .media-uploader .upload-area {
        border: 2px dashed #ddd;
        border-radius: 10px;
        padding: 2rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .media-uploader .upload-area:hover,
    .media-uploader .upload-area.drag-over {
        border-color: #4361ee;
        background: rgba(67, 97, 238, 0.05);
    }
    
    .upload-icon {
        color: #4361ee;
        margin-bottom: 1rem;
    }
    
    .preview-item {
        text-align: center;
        margin-top: 1rem;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 10px;
    }
</style>
@endpush