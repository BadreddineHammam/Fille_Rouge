---
marp: true
theme: default
paginate: true
footer: "Network Pro | Web Development Project"
size: 16:9
style: |
  section {
    background: #f5f7f8;
    color: #172a3a;
    font-family: "Aptos", "Segoe UI", sans-serif;
    font-size: 25px;
    padding: 48px 64px;
  }
  h1, h2, h3 {
    color: #12324a;
    letter-spacing: -0.02em;
  }
  h1 {
    font-size: 1.65em;
    margin-bottom: 0.55em;
  }
  h2 {
    font-size: 1.2em;
  }
  strong {
    color: #087e83;
  }
  section.lead {
    background: linear-gradient(135deg, #102d43 0%, #145b67 100%);
    color: #ffffff;
    justify-content: center;
  }
  section.lead h1, section.lead h2, section.lead strong {
    color: #ffffff;
  }
  section.lead h1 {
    font-size: 2.2em;
  }
  section.lead p {
    color: #d7e8eb;
  }
  section::after {
    color: #587081;
    font-size: 0.6em;
  }
  table {
    background: #ffffff;
    border: 1px solid #dce5e9;
    border-radius: 8px;
    font-size: 0.78em;
    table-layout: fixed;
    width: 100%;
  }
  th {
    background: #e5eff2;
    color: #12324a;
  }
  th, td {
    border-color: #dce5e9;
    overflow-wrap: anywhere;
    padding: 9px 12px;
  }
  code {
    color: #087e83;
  }
  blockquote {
    background: #e4f2f1;
    border-left: 5px solid #0c9a9b;
    color: #234b55;
    margin-left: 0;
    padding: 8px 18px;
  }
---

<!-- _class: lead -->

Web application | Publication management

# Network Pro

## A professional feed for learning CRUD

**Badreddine Hammam**  
Supervised by Mr. ESSARRAJ Fouad



---

<p style="color:#0c9a9b;font-size:0.72em;font-weight:700;letter-spacing:0.12em">THE PROJECT</p>

# A simple feed, a complete web journey

Network Pro is an educational prototype for managing professional posts from one web page.

- Learn the four CRUD operations.
- Send browser requests to a PHP API.
- Store posts in an easy-to-read JSON file.

**Scope:** a shared demo feed, with no accounts or login.

---

<p style="color:#0c9a9b;font-size:0.72em;font-weight:700;letter-spacing:0.12em">CORE FEATURES</p>

# One feed supports four actions

| Action | What the user can do |
|---|---|
| **CREATE** | Write and publish a post |
| **READ** | View recent posts |
| **UPDATE** | Edit an existing post |
| **DELETE** | Remove a post after confirmation |

All four actions are available from the same interface.

---

<p style="color:#0c9a9b;font-size:0.72em;font-weight:700;letter-spacing:0.12em">DESIGN APPROACH | 2TUP</p>

# Two perspectives meet in implementation

| Functional branch | Technical branch | Implementation |
|---|---|---|
| Define post-management needs | Select HTML, JavaScript, PHP and JSON | Bring both branches together |

**Functional needs** → **Technical solution** → **Working prototype**

2TUP is used as a conceptual guide; the report does not claim that every formal phase was completed.

---

<p style="color:#0c9a9b;font-size:0.72em;font-weight:700;letter-spacing:0.12em">DESIGN APPROACH | DESIGN THINKING</p>

# A prototype makes the idea tangible

| 1. Empathize | 2. Define | 3. Ideate | 4. Prototype | 5. Test |
|---|---|---|---|---|
| Understand users | Frame the problem | Explore solutions | Build a simple version | Learn and improve |

Network Pro is a small prototype for exploring post management. No user research or testing sessions are documented.

---

<p style="color:#0c9a9b;font-size:0.72em;font-weight:700;letter-spacing:0.12em">SYSTEM ARCHITECTURE</p>

# Each layer has a clear responsibility

**Browser** → **PHP API** → **Service** → **DAO** → **JSON file**

| Layer | Main responsibility |
|---|---|
| Browser | Display the feed and collect user actions |
| API and service | Handle requests and validate data |
| DAO and JSON | Read and save posts |

The API returns JSON responses to the browser.

---

<p style="color:#0c9a9b;font-size:0.72em;font-weight:700;letter-spacing:0.12em">POST DATA</p>

# A post has five straightforward fields

| Field | Purpose |
|---|---|
| `id` | Unique identifier |
| `author` | Author's name |
| `role` | Author's job or role |
| `content` | Post text |
| `createdAt` | Creation date and time in ISO format |

Posts are stored as JSON objects in a file.

---

<p style="color:#0c9a9b;font-size:0.72em;font-weight:700;letter-spacing:0.12em">CRUD THROUGH HTTP</p>

# The HTTP method selects the operation

| CRUD action | HTTP method | Server action |
|---|---|---|
| Read | `GET` | Return the post list |
| Create | `POST` | Validate and save a new post |
| Update | `PUT` | Validate and update a post |
| Delete | `DELETE` | Remove the selected post |

Every action uses `backend/api/posts.php`.

---

<p style="color:#0c9a9b;font-size:0.72em;font-weight:700;letter-spacing:0.12em">VALIDATION AND EXPERIENCE</p>

# Validation keeps posts consistent

| Field | Requirement |
|---|---|
| Author name | Required; up to 80 characters |
| Role | Required; up to 100 characters |
| Post content | Required; up to 1,000 characters |

The interface also provides success and error messages, an edit-cancel action, and a delete confirmation.

---

<p style="color:#0c9a9b;font-size:0.72em;font-weight:700;letter-spacing:0.12em">TESTING</p>

# Tests cover the main flow and key errors

- Create, read, update and delete a post.
- Reject an empty author name.
- Report a post that cannot be found.
- Use a temporary data file to protect demo content.

Run from the `file_rouge` folder:

`php .\tests\test_post.php`

---

<p style="color:#0c9a9b;font-size:0.72em;font-weight:700;letter-spacing:0.12em">RUN LOCALLY</p>

# Start the app with PHP CLI

1. Open the `file_rouge` folder in a terminal.
2. Run `php -S localhost:8000`.
3. Visit `http://localhost:8000` in a browser.

**Requirements:** PHP CLI 8.1+ and write access to the JSON data file.

Tailwind CSS loads from a CDN, so an internet connection is needed for styling.

---

<p style="color:#0c9a9b;font-size:0.72em;font-weight:700;letter-spacing:0.12em">LIMITS AND NEXT STEPS</p>

# A clear starting point, not a full social network

**Current limits:** no accounts, comments, reactions, private messages or database.

**Possible next steps:** add authentication, move to a relational database, add search, and expand API and interface tests.

Keep the layers separate as the project grows.

---

<!-- _class: lead -->

<p style="color:#8de0d7;font-size:0.72em;font-weight:700;letter-spacing:0.12em">TAKEAWAY</p>

# One idea. One flow. Four operations.

Network Pro shows how JavaScript, a PHP API and JSON storage work together to manage posts.

## Thank you | Questions?
