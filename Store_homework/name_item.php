
<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <title>ទម្រង់បញ្ចូលព័ត៌មានសិស្ស</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-8">
    <?php
    session_start();
    require_once 'name_item.php';

    // Check for edit mode
    $student = null;
    $isEditMode = false;
    if (isset($_GET['id'])) {
        $studentManager = new StudentManager();
        $student = $studentManager->getStudentById($_GET['id']);
        $isEditMode = true;
    }

    // Handle error messages
    $error_message = $_SESSION['error_message'] ?? '';
    unset($_SESSION['error_message']);
    ?>

    <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-center">
            <?= $isEditMode ? 'កែសម្រួលព័ត៌មានសិស្ស' : 'ទម្រង់បញ្ចូលព័ត៌មានសិស្ស' ?>
        </h2>

        <?php if (!empty($error_message)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <?= htmlspecialchars($error_message) ?>
            </div>
        <?php endif; ?>

        <form 
            action="student_process.php" 
            method="POST" 
            enctype="multipart/form-data" 
            class="space-y-4"
        >
            <?php if ($isEditMode): ?>
                <input type="hidden" name="student_id" value="<?= $student['id'] ?>">
            <?php endif; ?>

            <!-- Profile Image Upload -->
            <div class="mb-4">
                <label class="block mb-2">រូបភាពប្រចាំខ្លួន</label>
                <div class="flex flex-col items-center">
                    <?php if ($isEditMode && !empty($student['profile_image'])): ?>
                        <img 
                            src="<?= htmlspecialchars($student['profile_image']) ?>" 
                            alt="Current Profile" 
                            class="w-32 h-32 object-cover rounded-full mb-4"
                        >
                    <?php endif; ?>
                    <input 
                        type="file" 
                        name="profile_image" 
                        accept="image/*" 
                        class="w-full px-3 py-2 border rounded-md"
                    >
                </div>
            </div>
            
            <div>
                <label class="block mb-2">ឈ្មោះសិស្ស (ឧ. សេង ស៊ង់)</label>
                <input 
                    type="text" 
                    name="student_name" 
                    value="<?= $isEditMode ? htmlspecialchars($student['name']) : '' ?>"
                    required 
                    class="w-full px-3 py-2 border rounded-md"
                >
            </div>
            
            <div>
                <label class="block mb-2">អាយុ</label>
                <input 
                    type="number" 
                    name="age" 
                    value="<?= $isEditMode ? $student['age'] : '' ?>"
                    min="10" 
                    max="25" 
                    required
                    class="w-full px-3 py-2 border rounded-md"
                >
            </div>
            
            <div>
                <label class="block mb-2">ពិន្ទុវិជ្ជាសាច្រើន (សូមបញ្ចូល 4 ពិន្ទុ)</label>
                <div class="grid grid-cols-2 gap-4">
                    <?php 
                    $scores = $isEditMode ? $student['scores'] : array_fill(0, 4, '');
                    foreach ($scores as $index => $score): 
                    ?>
                        <input 
                            type="number" 
                            name="scores[]" 
                            value="<?= $score ?>"
                            min="0" 
                            max="100" 
                            required 
                            placeholder="ពិន្ទុទី <?= $index + 1 ?>"
                            class="px-3 py-2 border rounded-md"
                        >
                    <?php endforeach; ?>
                </div>
            </div>
            
            <div class="flex space-x-4">
                <button 
                    type="submit" 
                    class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600"
                >
                    <?= $isEditMode ? 'កែសម្រួល' : 'បញ្ចូល' ?>
                </button>
                <a 
                    href="student_list.php" 
                    class="w-full bg-gray-300 text-gray-700 py-2 rounded-md text-center hover:bg-gray-400"
                >
                    Cancel
                </a>
            </div>
        </form>
    </div>
</body>
</html>
