# API Documentation - Posts & Communities CRUD

## Base URL
```
http://127.0.0.1:8000/api
```

**Authentication:** Semua endpoint (kecuali login/register) memerlukan Bearer token dari Sanctum.

**Headers untuk semua request:**
```
Content-Type: application/json
Accept: application/json
Authorization: Bearer {your_token_here}
```

---

## 📝 Posts API

### 1. Get All Posts
**Endpoint:** `GET /api/posts`

**Query Parameters:**
- `user_id` (optional) - Filter posts by user ID
- `per_page` (optional, default: 15) - Number of posts per page

**Response (200):**
```json
{
  "data": [
    {
      "id": 1,
      "user": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "profile_picture": "http://127.0.0.1:8000/storage/users/profile.jpg",
        "bio": "Hello world",
        "role": "user",
        "status": "active",
        "followers_count": 10,
        "following_count": 5
      },
      "content": "This is my first post!",
      "image": "http://127.0.0.1:8000/storage/posts/image.jpg",
      "likes_count": 5,
      "views": 100,
      "bookmarks_count": 2,
      "replies_count": 3,
      "status": "active",
      "is_liked": false,
      "is_bookmarked": false,
      "is_owner": false,
      "created_at": "2025-12-28T03:30:00.000000Z",
      "updated_at": "2025-12-28T03:30:00.000000Z"
    }
  ],
  "links": {...},
  "meta": {...}
}
```

---

### 2. Create Post
**Endpoint:** `POST /api/posts`

**Request Body (multipart/form-data):**
```
content: "Your post content here" (required, max: 5000 chars)
image: [file] (optional, jpeg/jpg/png/gif, max: 2MB)
```

**Response (201):**
```json
{
  "success": true,
  "message": "Post berhasil dibuat",
  "data": {
    "id": 1,
    "user": {...},
    "content": "Your post content here",
    "image": "http://127.0.0.1:8000/storage/posts/image.jpg",
    "likes_count": 0,
    "views": 0,
    "bookmarks_count": 0,
    "status": "active",
    "is_liked": false,
    "is_bookmarked": false,
    "is_owner": true,
    "created_at": "2025-12-28T03:30:00.000000Z",
    "updated_at": "2025-12-28T03:30:00.000000Z"
  }
}
```

---

### 3. Get Single Post
**Endpoint:** `GET /api/posts/{id}`

**Response (200):**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "user": {...},
    "content": "Post content",
    "image": "http://127.0.0.1:8000/storage/posts/image.jpg",
    "likes_count": 5,
    "views": 101,
    "bookmarks_count": 2,
    "replies_count": 3,
    "status": "active",
    "is_liked": false,
    "is_bookmarked": false,
    "is_owner": false,
    "created_at": "2025-12-28T03:30:00.000000Z",
    "updated_at": "2025-12-28T03:30:00.000000Z"
  }
}
```

**Note:** View count akan bertambah otomatis jika user login dan bukan pemilik post.

---

### 4. Update Post
**Endpoint:** `PUT /api/posts/{id}` atau `PATCH /api/posts/{id}`

**Authorization:** Hanya pemilik post yang bisa update.

**Request Body (multipart/form-data):**
```
content: "Updated content" (required, max: 5000 chars)
image: [file] (optional, jpeg/jpg/png/gif, max: 2MB)
_method: PUT (jika menggunakan POST dengan multipart)
```

**Response (200):**
```json
{
  "success": true,
  "message": "Post berhasil diupdate",
  "data": {
    "id": 1,
    "user": {...},
    "content": "Updated content",
    "image": "http://127.0.0.1:8000/storage/posts/new_image.jpg",
    ...
  }
}
```

**Error (403):**
```json
{
  "success": false,
  "message": "Anda tidak memiliki akses untuk mengupdate post ini"
}
```

---

### 5. Delete Post
**Endpoint:** `DELETE /api/posts/{id}`

**Authorization:** Hanya pemilik post yang bisa delete.

**Response (200):**
```json
{
  "success": true,
  "message": "Post berhasil dihapus"
}
```

**Error (403):**
```json
{
  "success": false,
  "message": "Anda tidak memiliki akses untuk menghapus post ini"
}
```

---

## 🏘️ Communities API

### 1. Get All Communities
**Endpoint:** `GET /api/communities`

**Query Parameters:**
- `category` (optional) - Filter by category
- `search` (optional) - Search by community name
- `per_page` (optional, default: 15) - Number of communities per page

**Response (200):**
```json
{
  "data": [
    {
      "id": 1,
      "name": "Laravel Developers",
      "slug": "laravel-developers",
      "description": "A community for Laravel enthusiasts",
      "category": "Programming",
      "owner": {
        "id": 1,
        "name": "John Doe",
        ...
      },
      "owner_id": 1,
      "members_count": 50,
      "profile_image": "http://127.0.0.1:8000/storage/komunitas/profile.jpg",
      "background_image": "http://127.0.0.1:8000/storage/komunitas/bg.jpg",
      "is_member": false,
      "is_owner": false,
      "created_at": "2025-12-28T03:30:00.000000Z",
      "updated_at": "2025-12-28T03:30:00.000000Z"
    }
  ],
  "links": {...},
  "meta": {...}
}
```

---

### 2. Create Community
**Endpoint:** `POST /api/communities`

**Authorization:** User harus **subscribed** atau **admin**.

**Request Body (multipart/form-data):**
```
name: "Community Name" (required, max: 255 chars)
description: "Community description" (optional)
category: "Category name" (optional, max: 255 chars)
profile_image: [file] (optional, jpg/jpeg/png, max: 2MB)
background_image: [file] (optional, jpg/jpeg/png, max: 2MB)
```

**Response (201):**
```json
{
  "success": true,
  "message": "Komunitas berhasil dibuat",
  "data": {
    "id": 1,
    "name": "Community Name",
    "slug": "community-name",
    "description": "Community description",
    "category": "Category name",
    "owner": {...},
    "owner_id": 1,
    "members_count": 1,
    "profile_image": "http://127.0.0.1:8000/storage/komunitas/profile.jpg",
    "background_image": "http://127.0.0.1:8000/storage/komunitas/bg.jpg",
    "is_member": true,
    "is_owner": true,
    "created_at": "2025-12-28T03:30:00.000000Z",
    "updated_at": "2025-12-28T03:30:00.000000Z"
  }
}
```

**Error (403):**
```json
{
  "success": false,
  "message": "Kamu harus berlangganan terlebih dahulu untuk membuat komunitas."
}
```

**Note:** Pembuat komunitas otomatis menjadi member.

---

### 3. Get Single Community
**Endpoint:** `GET /api/communities/{id}`

**Response (200):**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "name": "Laravel Developers",
    "slug": "laravel-developers",
    "description": "A community for Laravel enthusiasts",
    "category": "Programming",
    "owner": {...},
    "owner_id": 1,
    "members_count": 50,
    "profile_image": "http://127.0.0.1:8000/storage/komunitas/profile.jpg",
    "background_image": "http://127.0.0.1:8000/storage/komunitas/bg.jpg",
    "is_member": false,
    "is_owner": false,
    "created_at": "2025-12-28T03:30:00.000000Z",
    "updated_at": "2025-12-28T03:30:00.000000Z"
  }
}
```

---

### 4. Update Community
**Endpoint:** `PUT /api/communities/{id}` atau `PATCH /api/communities/{id}`

**Authorization:** Hanya **owner** (yang subscribed) atau **admin** yang bisa update.

**Request Body (multipart/form-data):**
```
name: "Updated Name" (required, max: 255 chars)
description: "Updated description" (optional)
category: "Updated category" (optional, max: 255 chars)
profile_image: [file] (optional, jpg/jpeg/png, max: 2MB)
background_image: [file] (optional, jpg/jpeg/png, max: 2MB)
_method: PUT (jika menggunakan POST dengan multipart)
```

**Response (200):**
```json
{
  "success": true,
  "message": "Komunitas berhasil diperbarui",
  "data": {
    "id": 1,
    "name": "Updated Name",
    "slug": "updated-name",
    ...
  }
}
```

**Error (403):**
```json
{
  "success": false,
  "message": "Kamu tidak punya akses untuk mengupdate komunitas ini"
}
```

---

### 5. Delete Community
**Endpoint:** `DELETE /api/communities/{id}`

**Authorization:** Hanya **owner** (yang subscribed) atau **admin** yang bisa delete.

**Response (200):**
```json
{
  "success": true,
  "message": "Komunitas berhasil dihapus"
}
```

**Error (403):**
```json
{
  "success": false,
  "message": "Kamu tidak punya akses untuk menghapus komunitas ini"
}
```

---

## 🔐 Authentication Endpoints

### Login
**Endpoint:** `POST /api/login`

**Request Body:**
```json
{
  "email": "user@example.com",
  "password": "password123"
}
```

**Response (200):**
```json
{
  "success": true,
  "message": "Login berhasil",
  "data": {
    "user": {...},
    "token": "1|xxxxxxxxxxxxxxxxxxxxx"
  }
}
```

### Register
**Endpoint:** `POST /api/register`

**Request Body:**
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

### Get Profile
**Endpoint:** `GET /api/profile`

**Headers:** `Authorization: Bearer {token}`

### Logout
**Endpoint:** `POST /api/logout`

**Headers:** `Authorization: Bearer {token}`

---

## 📱 Flutter Implementation Examples

### 1. Create Post with Image

```dart
import 'package:http/http.dart' as http;
import 'dart:convert';

Future<Map<String, dynamic>> createPost(
  String token,
  String content,
  File? image,
) async {
  var request = http.MultipartRequest(
    'POST',
    Uri.parse('http://127.0.0.1:8000/api/posts'),
  );
  
  request.headers['Authorization'] = 'Bearer $token';
  request.headers['Accept'] = 'application/json';
  
  request.fields['content'] = content;
  
  if (image != null) {
    request.files.add(
      await http.MultipartFile.fromPath('image', image.path),
    );
  }
  
  var response = await request.send();
  var responseBody = await response.stream.bytesToString();
  
  return jsonDecode(responseBody);
}
```

### 2. Get Posts with Pagination

```dart
Future<Map<String, dynamic>> getPosts(
  String token,
  {int page = 1, int perPage = 15}
) async {
  final response = await http.get(
    Uri.parse('http://127.0.0.1:8000/api/posts?page=$page&per_page=$perPage'),
    headers: {
      'Authorization': 'Bearer $token',
      'Accept': 'application/json',
    },
  );
  
  return jsonDecode(response.body);
}
```

### 3. Update Post

```dart
Future<Map<String, dynamic>> updatePost(
  String token,
  int postId,
  String content,
  File? newImage,
) async {
  var request = http.MultipartRequest(
    'POST', // Use POST with _method field
    Uri.parse('http://127.0.0.1:8000/api/posts/$postId'),
  );
  
  request.headers['Authorization'] = 'Bearer $token';
  request.headers['Accept'] = 'application/json';
  
  request.fields['_method'] = 'PUT';
  request.fields['content'] = content;
  
  if (newImage != null) {
    request.files.add(
      await http.MultipartFile.fromPath('image', newImage.path),
    );
  }
  
  var response = await request.send();
  var responseBody = await response.stream.bytesToString();
  
  return jsonDecode(responseBody);
}
```

### 4. Delete Post

```dart
Future<Map<String, dynamic>> deletePost(String token, int postId) async {
  final response = await http.delete(
    Uri.parse('http://127.0.0.1:8000/api/posts/$postId'),
    headers: {
      'Authorization': 'Bearer $token',
      'Accept': 'application/json',
    },
  );
  
  return jsonDecode(response.body);
}
```

### 5. Create Community

```dart
Future<Map<String, dynamic>> createCommunity(
  String token,
  String name,
  String? description,
  String? category,
  File? profileImage,
  File? backgroundImage,
) async {
  var request = http.MultipartRequest(
    'POST',
    Uri.parse('http://127.0.0.1:8000/api/communities'),
  );
  
  request.headers['Authorization'] = 'Bearer $token';
  request.headers['Accept'] = 'application/json';
  
  request.fields['name'] = name;
  if (description != null) request.fields['description'] = description;
  if (category != null) request.fields['category'] = category;
  
  if (profileImage != null) {
    request.files.add(
      await http.MultipartFile.fromPath('profile_image', profileImage.path),
    );
  }
  
  if (backgroundImage != null) {
    request.files.add(
      await http.MultipartFile.fromPath('background_image', backgroundImage.path),
    );
  }
  
  var response = await request.send();
  var responseBody = await response.stream.bytesToString();
  
  return jsonDecode(responseBody);
}
```

---

## ⚠️ Error Responses

### Validation Error (422)
```json
{
  "success": false,
  "message": "Validasi gagal",
  "errors": {
    "content": ["The content field is required."],
    "image": ["The image must be an image."]
  }
}
```

### Unauthorized (401)
```json
{
  "message": "Unauthenticated."
}
```

### Forbidden (403)
```json
{
  "success": false,
  "message": "Anda tidak memiliki akses untuk mengupdate post ini"
}
```

### Not Found (404)
```json
{
  "success": false,
  "message": "Post tidak ditemukan"
}
```

---

## 👥 Admin User Management API

> **⚠️ Admin Only:** All endpoints di section ini memerlukan role **admin**. Non-admin akan mendapat error 403.

### 1. Get All Users
**Endpoint:** `GET /api/admin/users`

**Authorization:** Admin only

**Query Parameters:**
- `search` (optional) - Search by name or email
- `status` (optional) - Filter by status (active/blocked)
- `role` (optional) - Filter by role (user/admin)
- `per_page` (optional, default: 15) - Number of users per page

**Response (200):**
```json
{
  "data": [
    {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com",
      "profile_picture": "http://127.0.0.1:8000/storage/users/profile.jpg",
      "bio": "Hello world",
      "hobi": "Reading",
      "role": "user",
      "status": "active",
      "followers_count": 10,
      "following_count": 5,
      "is_subscribed": true,
      "created_at": "2025-12-28T03:30:00.000000Z",
      "updated_at": "2025-12-28T03:30:00.000000Z"
    }
  ],
  "links": {...},
  "meta": {...}
}
```

---

### 2. Create User (Admin)
**Endpoint:** `POST /api/admin/users`

**Authorization:** Admin only

**Request Body:**
```json
{
  "name": "New User",
  "email": "newuser@example.com",
  "password": "password123",
  "role": "user",
  "status": "active",
  "bio": "User bio",
  "hobi": "Gaming"
}
```

**Response (201):**
```json
{
  "success": true,
  "message": "User berhasil dibuat",
  "data": {
    "id": 10,
    "name": "New User",
    "email": "newuser@example.com",
    "role": "user",
    "status": "active",
    ...
  }
}
```

---

### 3. Get Single User (Admin)
**Endpoint:** `GET /api/admin/users/{id}`

**Authorization:** Admin only

**Response (200):**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "role": "user",
    "status": "active",
    ...
  }
}
```

---

### 4. Update User (Admin)
**Endpoint:** `PUT /api/admin/users/{id}` atau `PATCH /api/admin/users/{id}`

**Authorization:** Admin only

**Request Body:**
```json
{
  "name": "Updated Name",
  "email": "updated@example.com",
  "password": "newpassword123",
  "role": "admin",
  "status": "active",
  "bio": "Updated bio",
  "hobi": "Updated hobi"
}
```

**Note:** Password optional, hanya update jika diisi.

**Response (200):**
```json
{
  "success": true,
  "message": "User berhasil diupdate",
  "data": {
    "id": 1,
    "name": "Updated Name",
    "email": "updated@example.com",
    ...
  }
}
```

---

### 5. Delete User (Admin)
**Endpoint:** `DELETE /api/admin/users/{id}`

**Authorization:** Admin only

**Response (200):**
```json
{
  "success": true,
  "message": "User berhasil dihapus"
}
```

**Error (403):**
```json
{
  "success": false,
  "message": "Anda tidak dapat menghapus akun Anda sendiri"
}
```

**Note:** Admin tidak bisa menghapus akun mereka sendiri.

---

### 6. Block User
**Endpoint:** `POST /api/admin/users/{id}/block`

**Authorization:** Admin only

**Response (200):**
```json
{
  "success": true,
  "message": "User berhasil diblokir",
  "data": {
    "id": 1,
    "name": "John Doe",
    "status": "blocked",
    ...
  }
}
```

**Error (403):**
```json
{
  "success": false,
  "message": "Anda tidak dapat memblokir akun Anda sendiri"
}
```

---

### 7. Unblock User
**Endpoint:** `POST /api/admin/users/{id}/unblock`

**Authorization:** Admin only

**Response (200):**
```json
{
  "success": true,
  "message": "User berhasil di-unblock",
  "data": {
    "id": 1,
    "name": "John Doe",
    "status": "active",
    ...
  }
}
```

---

### 8. Get User Statistics
**Endpoint:** `GET /api/admin/users/stats`

**Authorization:** Admin only

**Response (200):**
```json
{
  "success": true,
  "data": {
    "total_users": 150,
    "active_users": 140,
    "blocked_users": 10,
    "admin_users": 3,
    "subscribed_users": 25
  }
}
```

---

## 📱 Flutter Implementation Examples (Admin)

### 1. Get All Users with Search

```dart
Future<Map<String, dynamic>> getUsers(
  String adminToken,
  {String? search, String? status, int page = 1}
) async {
  var uri = Uri.parse('http://127.0.0.1:8000/api/admin/users');
  
  // Add query parameters
  var queryParams = {'page': page.toString()};
  if (search != null) queryParams['search'] = search;
  if (status != null) queryParams['status'] = status;
  
  uri = uri.replace(queryParameters: queryParams);
  
  final response = await http.get(
    uri,
    headers: {
      'Authorization': 'Bearer $adminToken',
      'Accept': 'application/json',
    },
  );
  
  return jsonDecode(response.body);
}
```

### 2. Create User (Admin)

```dart
Future<Map<String, dynamic>> createUser(
  String adminToken,
  String name,
  String email,
  String password,
  {String role = 'user', String status = 'active'}
) async {
  final response = await http.post(
    Uri.parse('http://127.0.0.1:8000/api/admin/users'),
    headers: {
      'Authorization': 'Bearer $adminToken',
      'Content-Type': 'application/json',
      'Accept': 'application/json',
    },
    body: jsonEncode({
      'name': name,
      'email': email,
      'password': password,
      'role': role,
      'status': status,
    }),
  );
  
  return jsonDecode(response.body);
}
```

### 3. Update User (Admin)

```dart
Future<Map<String, dynamic>> updateUser(
  String adminToken,
  int userId,
  Map<String, dynamic> userData,
) async {
  final response = await http.put(
    Uri.parse('http://127.0.0.1:8000/api/admin/users/$userId'),
    headers: {
      'Authorization': 'Bearer $adminToken',
      'Content-Type': 'application/json',
      'Accept': 'application/json',
    },
    body: jsonEncode(userData),
  );
  
  return jsonDecode(response.body);
}
```

### 4. Block/Unblock User

```dart
Future<Map<String, dynamic>> blockUser(String adminToken, int userId) async {
  final response = await http.post(
    Uri.parse('http://127.0.0.1:8000/api/admin/users/$userId/block'),
    headers: {
      'Authorization': 'Bearer $adminToken',
      'Accept': 'application/json',
    },
  );
  
  return jsonDecode(response.body);
}

Future<Map<String, dynamic>> unblockUser(String adminToken, int userId) async {
  final response = await http.post(
    Uri.parse('http://127.0.0.1:8000/api/admin/users/$userId/unblock'),
    headers: {
      'Authorization': 'Bearer $adminToken',
      'Accept': 'application/json',
    },
  );
  
  return jsonDecode(response.body);
}
```

### 5. Get User Statistics

```dart
Future<Map<String, dynamic>> getUserStats(String adminToken) async {
  final response = await http.get(
    Uri.parse('http://127.0.0.1:8000/api/admin/users/stats'),
    headers: {
      'Authorization': 'Bearer $adminToken',
      'Accept': 'application/json',
    },
  );
  
  return jsonDecode(response.body);
}
```

---

## ⚠️ Error Responses

### Validation Error (422)
```json
{
  "success": false,
  "message": "Validasi gagal",
  "errors": {
    "content": ["The content field is required."],
    "image": ["The image must be an image."]
  }
}
```

### Unauthorized (401)
```json
{
  "message": "Unauthenticated."
}
```

### Forbidden (403)
```json
{
  "success": false,
  "message": "Anda tidak memiliki akses untuk mengupdate post ini"
}
```

**Admin Forbidden:**
```json
{
  "success": false,
  "message": "Unauthorized. Admin access required."
}
```

### Not Found (404)
```json
{
  "success": false,
  "message": "Post tidak ditemukan"
}
```

---

## 📝 Notes

1. **Image Upload:** Gunakan `multipart/form-data` untuk upload gambar
2. **Update dengan Image:** Gunakan POST dengan field `_method=PUT` untuk update dengan image
3. **Pagination:** Response menggunakan Laravel pagination format dengan `data`, `links`, dan `meta`
4. **Authorization:** Semua endpoint (kecuali login/register) memerlukan Bearer token
5. **Admin Routes:** Endpoint `/api/admin/*` hanya bisa diakses oleh user dengan role `admin`
6. **IP Address:** Ganti `127.0.0.1` dengan IP komputer Anda jika test di device fisik
7. **Android Emulator:** Gunakan `10.0.2.2` sebagai pengganti `127.0.0.1`
8. **Community Creation:** Hanya user yang subscribed atau admin yang bisa membuat komunitas
9. **Self-Actions:** Admin tidak bisa block/delete akun mereka sendiri
