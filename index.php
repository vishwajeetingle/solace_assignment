<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photo Preview Editor</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
       
        html, body, #root {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif; 
            overflow: hidden; 
        }
        canvas {
            display: block;
            border: 1px solid #ccc;
            background-color: #f8f8f8;
            border-radius: 0.75rem; 
        }
        
        .file-input-hidden {
            display: none;
        }
     
        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800 antialiased flex flex-col h-screen">
    <?php
       
        echo '
        <div id="root" class="flex flex-1 p-4 gap-4">
            
            <div class="flex-1 flex items-center justify-center bg-white shadow-lg rounded-2xl p-6">
                <canvas id="photoCanvas" class="max-w-full max-h-full"></canvas>
            </div>

           
            <div class="w-96 bg-white shadow-lg rounded-2xl p-6 flex flex-col overflow-hidden">
                <h1 class="text-3xl font-extrabold text-indigo-700 mb-6 text-center">Photo Editor</h1>

                <div class="flex-grow custom-scrollbar overflow-y-auto pr-2">
                    
                    <section class="mb-8 p-4 bg-indigo-50 rounded-xl shadow-inner">
                        <h2 class="text-xl font-semibold text-indigo-600 mb-4 flex items-center">
                            <i class="fas fa-expand-arrows-alt mr-3"></i>Preview Size
                        </h2>
                        <div class="flex gap-4">
                            <div class="flex-1">
                                <label for="widthInput" class="block text-sm font-medium text-gray-700 mb-1">Width (px)</label>
                                <input type="number" id="widthInput" value="400" min="50" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition duration-200 ease-in-out">
                            </div>
                            <div class="flex-1">
                                <label for="heightInput" class="block text-sm font-medium text-gray-700 mb-1">Height (px)</label>
                                <input type="number" id="heightInput" value="300" min="50" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition duration-200 ease-in-out">
                            </div>
                        </div>
                    </section>

                    
                    <section class="mb-8 p-4 bg-purple-50 rounded-xl shadow-inner">
                        <h2 class="text-xl font-semibold text-purple-600 mb-4 flex items-center">
                            <i class="fas fa-image mr-3"></i>Image / Photo Layer
                        </h2>
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <button data-image-url="https://placehold.co/600x400/87CEEB/ffffff?text=Sky"
                             class="sample-image-btn p-3 bg-purple-200 text-purple-800 rounded-lg shadow-md hover:bg-purple-300 transition duration-200 ease-in-out font-medium text-sm flex items-center justify-center">
                                <i class="fas fa-cloud mr-2"></i>Sample 1
                            </button>
                            <button data-image-url="https://placehold.co/600x400/228B22/ffffff?text=Forest" class="sample-image-btn p-3 bg-purple-200 text-purple-800 rounded-lg shadow-md hover:bg-purple-300 transition duration-200 ease-in-out font-medium text-sm flex items-center justify-center">
                                <i class="fas fa-tree mr-2"></i>Sample 2
                            </button>
                            <button data-image-url="https://placehold.co/600x400/ADD8E6/ffffff?text=Ocean" class="sample-image-btn p-3 bg-purple-200 text-purple-800 rounded-lg shadow-md hover:bg-purple-300 transition duration-200 ease-in-out font-medium text-sm flex items-center justify-center">
                                <i class="fas fa-water mr-2"></i>Sample 3
                            </button>
                            <button data-image-url="https://placehold.co/600x400/F0E68C/000000?text=Desert" class="sample-image-btn p-3 bg-purple-200 text-purple-800 rounded-lg shadow-md hover:bg-purple-300 transition duration-200 ease-in-out font-medium text-sm flex items-center justify-center">
                                <i class="fas fa-sun mr-2"></i>Sample 4
                            </button>
                        </div>
                        <label for="uploadImage" class="block w-full text-center p-3 bg-purple-600 text-white rounded-lg shadow-lg hover:bg-purple-700 transition duration-200 ease-in-out cursor-pointer font-bold flex items-center justify-center">
                            <i class="fas fa-upload mr-3"></i>Choose Photo from Computer
                        </label>
                        <input type="file" id="uploadImage" accept="image/*" class="file-input-hidden">
                    </section>

                     
                    <section class="mb-8 p-4 bg-teal-50 rounded-xl shadow-inner">
                        <h2 class="text-xl font-semibold text-teal-600 mb-4 flex items-center">
                            <i class="fas fa-border-all mr-3"></i>Frame Layer
                        </h2>

                        <div class="grid grid-cols-2 gap-4">

                            <button data-frame-url="wooden_frame.png" class=" sample-frame-btn p-3 bg-teal-200 text-teal-800 rounded-lg shadow-md hover:bg-teal-300 transition duration-200 ease-in-out font-medium text-sm flex items-center justify-center">
                                <i class="fas fa-tree mr-2"></i>Wood Frame
                            </button>
                            <button data-frame-url="wooden_frame_silver.png" class="sample-frame-btn p-3 bg-teal-200 text-teal-800 rounded-lg shadow-md hover:bg-teal-300 transition duration-200 ease-in-out font-medium text-sm flex items-center justify-center">
                                <i class="fas fa-cog mr-2"></i>Metal Frame
                            </button>
                             <button data-frame-url="wooden_frame_golden.png" class="sample-frame-btn p-3 bg-teal-200 text-teal-800 rounded-lg shadow-md hover:bg-teal-300 transition duration-200 ease-in-out font-medium text-sm flex items-center justify-center">
                                <i class="fas fa-gem mr-2"></i>Gold Frame
                            </button>

                            <button data-frame-url="" class="sample-frame-btn p-3 bg-red-200 text-red-800 rounded-lg shadow-md hover:bg-red-300 transition duration-200 ease-in-out font-medium text-sm flex items-center justify-center">
                                <i class="fas fa-times-circle mr-2"></i>No Frame
                            </button>
                        </div>
                    </section>
                </div>

           
            </div>
        </div>

        <script>
            //  Canvas Setup 
            const canvas = document.getElementById(\'photoCanvas\');
            const ctx = canvas.getContext(\'2d\');

           
            let previewWidth = 400;
            let previewHeight = 270;
            let currentImage = null; 
            let currentFramePattern = null; 
            const frameThickness = 25; 

            // Elements 
            const widthInput = document.getElementById(\'widthInput\');
            const heightInput = document.getElementById(\'heightInput\');
            const sampleImageBtns = document.querySelectorAll(\'.sample-image-btn\');
            const uploadImageInput = document.getElementById(\'uploadImage\');
            const sampleFrameBtns = document.querySelectorAll(\'.sample-frame-btn\');

            // Drawing Function 
            function drawCanvas() {
                
                ctx.clearRect(0, 0, canvas.width, canvas.height);

                
                const offsetX = (canvas.width - previewWidth) / 2;
                const offsetY = (canvas.height - previewHeight) / 2;

                
                ctx.fillStyle = \'#e0e0e0\'; 
                ctx.fillRect(offsetX, offsetY, previewWidth, previewHeight);

               
                if (currentImage) {
                   
                    const imageAspectRatio = currentImage.width / currentImage.height;
                    const previewAspectRatio = previewWidth / previewHeight;

                    let imgDrawWidth = previewWidth;
                    let imgDrawHeight = previewHeight;
                    let imgDrawX = offsetX;
                    let imgDrawY = offsetY;

                    if (imageAspectRatio > previewAspectRatio) {
                        
                        imgDrawHeight = previewWidth / imageAspectRatio;
                        imgDrawY = offsetY + (previewHeight - imgDrawHeight) / 2; 
                    } else {
                        
                        imgDrawWidth = previewHeight * imageAspectRatio;
                        imgDrawX = offsetX + (previewWidth - imgDrawWidth) / 2; 
                    }

                    // Draw the image
                    ctx.drawImage(currentImage, imgDrawX, imgDrawY, imgDrawWidth, imgDrawHeight);
                } else {
                   
                    ctx.fillStyle = \'#999\';
                    ctx.font = \'20px Inter, sans-serif\';
                    ctx.textAlign = \'center\';
                    ctx.textBaseline = \'middle\';
                    ctx.fillText(\'No Image Selected\', offsetX + previewWidth / 2, offsetY + previewHeight / 2);
                }

                // Draw the frame if available
                if (currentFramePattern) {
                   
                    const frameDrawX = offsetX - frameThickness;
                    const frameDrawY = offsetY - frameThickness;
                    const frameDrawWidth = previewWidth + (frameThickness * 2);
                    const frameDrawHeight = previewHeight + (frameThickness * 2);

                    ctx.drawImage(currentFramePattern, frameDrawX, frameDrawY, frameDrawWidth, frameDrawHeight);
                }

               
                if (!currentFramePattern) {
                    ctx.strokeStyle = \'#ccc\';
                    ctx.lineWidth = 2;
                    ctx.strokeRect(offsetX, offsetY, previewWidth, previewHeight);
                }
                    
            }

            //  Image Loading Helper
            function loadImage(src, callback) {
                const img = new Image();
                img.onload = () => callback(img);
                img.onerror = () => {
                   
                    const fallbackImg = new Image();
                    fallbackImg.onload = () => callback(fallbackImg);
                    fallbackImg.src = `https://placehold.co/${img.width || 600}x${img.height || 400}/FF6347/ffffff?text=Error`;
                };
                img.src = src;
            }

            //  Event Listeners

            // 1. Size Input
            widthInput.addEventListener(\'input\', () => {
                previewWidth = parseInt(widthInput.value) || 0;
                drawCanvas();
            });

            heightInput.addEventListener(\'input\', () => {
                previewHeight = parseInt(heightInput.value) || 0;
                drawCanvas();
            });

            // 2. Sample Images
            sampleImageBtns.forEach(button => {
                button.addEventListener(\'click\', () => {
                    const imageUrl = button.dataset.imageUrl;
                    loadImage(imageUrl, (img) => {
                        currentImage = img;
                        drawCanvas();
                    });
                });
            });

            // 3. Upload Image from Computer
            uploadImageInput.addEventListener(\'change\', (event) => {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        loadImage(e.target.result, (img) => {
                            currentImage = img;
                            drawCanvas();
                        });
                    };
                    reader.readAsDataURL(file);
                }
            });

            // 4. Frame Selection
            sampleFrameBtns.forEach(button => {
                button.addEventListener(\'click\', () => {
                    const frameUrl = button.dataset.frameUrl;
                    if (frameUrl) {
                        loadImage(frameUrl, (img) => {
                            currentFramePattern = img;
                            drawCanvas();
                        });
                    } else {
                        currentFramePattern = null; 
                        drawCanvas();
                    }
                });
            });

            // Canvas Responsiveness
            function resizeCanvas() {
               
                const parent = canvas.parentElement;
                canvas.style.width = \'100%\';
                canvas.style.height = \'100%\';
               
                const displayWidth = parent.clientWidth;
                const displayHeight = parent.clientHeight;
                
                if (canvas.width !== displayWidth || canvas.height !== displayHeight) {
                    canvas.width = displayWidth;
                    canvas.height = displayHeight;
                    drawCanvas(); 
                }
            }

          
            // window.addEventListener(\'load\', () => {
            //     resizeCanvas(); 
            //    
            //     loadImage(sampleImageBtns[0].dataset.imageUrl, (img) => {
            //         currentImage = img;
            //        
            //         loadImage(sampleFrameBtns[0].dataset.frameUrl, (frameImg) => {
            //             currentFramePattern = frameImg;
            //             drawCanvas();
            //         });
            //     });
            // });

            window.addEventListener(\'load\', () => {
    resizeCanvas(); 
   
    // loadImage(sampleImageBtns[0].dataset.imageUrl, (img) => {
    //     currentImage = img;
    //     drawCanvas(); 
    // });
});

            window.addEventListener(\'resize\', resizeCanvas);
        </script>
        ';
    ?>
</body>
</html>