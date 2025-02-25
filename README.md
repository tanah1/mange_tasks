# API لإدارة المهام والمستخدمين باستخدام Laravel

هذا المشروع هو API مبني باستخدام Laravel لإدارة المستخدمين والمهام. يتيح للمستخدمين إمكانية التسجيل، تسجيل الدخول، إدارة ملفاتهم الشخصية، وإدارة المهام مثل إضافة، تعديل، عرض، وحذف المهام. كما يعتمد على **Sanctum** للمصادقة.

## المميزات

- **المصادقة والتوثيق باستخدام Sanctum**:
  - تسجيل الدخول والخروج.
  - إدارة حسابات المستخدمين (التسجيل، التحديث، عرض المستخدم).
  
- **إدارة المهام**:
  - إضافة مهام جديدة.
  - عرض جميع المهام أو مهام مستخدم معين.
  - تعديل المهام.
  - حذف المهام.

## المتطلبات

- PHP 8.0 أو أعلى.
- Composer.
- قاعدة بيانات SQLite.

## التثبيت

### 1. استنساخ المستودع:
```bash
git clone https://github.com/tanah1/manage-tasks.git

# API Documentation

يمكنك الوصول إلى توثيق الـ API الخاص بمشروعنا من خلال الرابط التالي:

[API Documentation on Postman]([https://documenter.getpostman.com/view/your_collection_link](https://web.postman.co/workspace/My-Workspace~cbd3fbc7-47c5-489e-8b4c-c8de43bef68f/collection/40212061-1c475b1f-064f-4681-8512-788ef1da8e8e?action=share&source=copy-link&creator=40212061))

يرجى ملاحظة أن هذا الرابط يحتوي على جميع النقاط النهائية (endpoints) للمشروع، بالإضافة إلى التفاصيل الخاصة بكل نقطة نهائية، مثل: الطرق (GET, POST, PUT, DELETE) والاستجابات.

---

## How to Use

1. **أولاً، قم بتسجيل الدخول باستخدام Postman**.
2. **ثم استخدم الـ API الموثق** لتنفيذ العمليات المطلوبة.


2. تثبيت التبعيات:
bash
Copy
Edit
cd todo-api
composer install
3. إعداد البيئة:
قم بنسخ ملف .env.example إلى .env:
bash
Copy
Edit
cp .env.example .env
قم بفتح الملف .env وضبط إعدادات قاعدة البيانات والتطبيق (مثل اسم المستخدم، كلمة المرور، إلخ).
4. إنشاء مفتاح التطبيق:
bash
Copy
Edit
php artisan key:generate
5. إعداد قاعدة البيانات:
تأكد من أن إعدادات قاعدة البيانات صحيحة في ملف .env.
ثم، قم بتشغيل المهاجرات لإنشاء الجداول:
bash
Copy
Edit
php artisan migrate
6. إعداد التوثيق باستخدام Sanctum:
قم بتثبيت الحزم الخاصة بـ Sanctum:
bash
Copy
Edit
composer require laravel/sanctum
نشر ملفات Sanctum:
bash
Copy
Edit
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
قم بتشغيل الأمر التالي لإنشاء Personal Access Token:
bash
Copy
Edit
php artisan migrate
الاستخدام
الطرق الرئيسية في API:
1. المستخدمين:
تسجيل مستخدم جديد:
POST /api/user/register
البيانات المطلوبة: name, email, password
تسجيل دخول:
POST /api/user/login
البيانات المطلوبة: email, password
تسجيل خروج:
POST /api/user/logout
محمي بـ auth:sanctum
عرض المستخدم الحالي:
GET /api/user
محمي بـ auth:sanctum
تحديث المستخدم:
PUT /api/user
محمي بـ auth:sanctum
2. المهام:
عرض جميع المهام:
GET /api/tasks
عرض مهمة معينة:
GET /api/tasks/{id}
عرض مهام المستخدم:
GET /api/user/tasks
محمي بـ auth:sanctum
إضافة مهمة جديدة:
POST /api/tasks
البيانات المطلوبة: title, desc, status
محمي بـ auth:sanctum
تحديث مهمة:
PUT /api/tasks/{id}
محمي بـ auth:sanctum
حذف مهمة:
DELETE /api/tasks/{id}
محمي بـ auth:sanctum
