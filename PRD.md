# TLab Ecosystem — Product Requirements Document (PRD)

**Version:** 1.0  
**Status:** Strategic Draft  
**Priority:** Highest (Phase 1)  
**Target Launch:** 8 Weeks  

---

## 1. Executive Summary

TLab is the specialized children-focused learning ecosystem under Edfrica, accessible via tlab.edfrica.org. The platform is designed as a safe, gamified, parent-controlled STEM and life-skills ecosystem for children aged 3–15 across Africa.

TLab serves both:
- **B2C** (Parents enrolling their children)
- **B2B** (Schools purchasing institutional licenses)

The platform combines gamified learning journeys, live/self-paced classes, XP and ranking systems, child-safe architecture, parent supervision tools, and school performance dashboards.

The core differentiator of TLab is its **Parent-First Learning Architecture**, where parents act as master account holders capable of managing multiple child profiles under a single ecosystem.

---

## 2. Vision Statement

To become Africa's leading gamified STEM and future-skills learning ecosystem for children by combining safe digital learning, parent supervision, and engaging educational experiences.

---

## 3. Target Personas

| Persona | Goal | Motivation |
|---------|------|------------|
| **The Student (Child)** | Learn through games, challenges, projects, and rewards | XP, badges, achievements, rankings, certificates |
| **The Parent/Guardian** | Monitor progress, manage subscriptions, ensure child safety | Visibility, control, measurable improvement |
| **The Teacher** | Manage cohorts, grade assignments, conduct live classes | Structured teaching workflows and analytics |
| **The School Administrator** | Manage bulk student enrollments, school-wide reporting | Centralized visibility and performance tracking |
| **Edfrica Super Admin** | Manage platform operations, curriculum, payments, compliance | Full system oversight |

---

## 4. Core Product Philosophy

1. **Safety First** — Children are never exposed to unsupervised interactions.
2. **Parent-Controlled Access** — All child activities exist within a controlled guardian ecosystem.
3. **Gamified Learning** — XP, ranks, badges, and leaderboards drive engagement.
4. **Mobile-First** — Designed for African mobile-first internet usage.
5. **African Accessibility** — Low-bandwidth friendly, affordable data usage.

---

## 5. Functional Requirements

### 5.1 Family Account Architecture

TLab operates using a **Parent-First Account System**. Parent/Guardian accounts act as master account holders. Children cannot independently create accounts.

**Child Profile Components:**
- Name, Age/DOB, Learning interests, Skill level
- XP and rankings, Certificates, Attendance records
- Portfolio projects, Course enrollments

**Parent Capabilities:**
- Create/manage multiple child profiles
- Switch between child dashboards
- Monitor attendance and progress
- View teacher feedback
- Manage subscriptions/payments
- Set login PINs
- Receive notifications
- Download certificates
- Approve enrollments and projects

**Child Restrictions:**
- No public profiles
- No peer-to-peer messaging
- No payment access
- Restricted uploads
- No access to account settings

---

### 5.2 Roles & Permissions

**Hierarchy:**
```
Super Admin → Content Manager → School Admin → Teacher → Parent → Student
```

**Role-based access control (RBAC)** enforced at route, controller, and view layers.

---

### 5.3 Child Safety & Moderation

- No student-to-student messaging
- Parent visibility into all interactions
- Moderated uploads (parent/teacher approval)
- Logged teacher communications
- Safe-link filtering (allowlisted domains only)
- Session recording support
- AI-assisted profanity detection (Phase 2)
- COPPA/GDPR-K aligned architecture

---

### 5.4 Authentication System

- Primary auth via `auth.edfrica.org` (OAuth2)
- Child access via **Username + 4-digit PIN**
- Role-based access control (RBAC)
- Session-based child authentication (independent of parent session)

---

### 5.5 Gamification Engine

**XP Rewards:**
| Action | XP |
|--------|----|
| Attend Session | +10 |
| Complete Challenge | +20 |
| Teamwork | +10 |
| Project Presentation | +15 |

**Rank Structure:**
| Rank | XP Required |
|------|-------------|
| Explorer | 0 |
| Innovator | 200 |
| Builder | 500 |
| Creator | 1000 |
| Master Inventor | 2000+ |

**Achievements:** Badges for milestones (first login, course complete, streak, etc.)

---

### 5.6 Learning Management System (LMS)

**Content Hierarchy:**
```
Club → Course → Cohort → Module → Lesson → Assessment
```

**Integrations:**
- Cloudflare Stream / Vimeo (video hosting)
- Trinket.io / Scratch (coding exercises)
- Zoom / Google Meet (live sessions)

**Assessment Types:**
- Multiple choice quizzes
- Coding challenges
- Project submissions
- Teacher-graded assignments

---

### 5.7 Teacher Portal

- Attendance marking per session
- Assignment review and grading
- XP awarding to students
- Cohort management
- Course progress tracking
- Communication logs with parents

---

### 5.8 Parent Portal

- Child switching (instant dashboard swap)
- Progress analytics (XP growth, attendance rate, course completion)
- Learning streaks tracking
- Subscription management
- Certificate downloads
- Notification preferences

---

### 5.9 School Portal (B2B)

- Bulk student onboarding via CSV upload
- License management (seat allocation)
- Institutional analytics (active students, completion rates)
- Teacher account provisioning
- School-wide attendance and grade reports

---

### 5.10 Admin Portal

- User management (all roles)
- Club/Course/Curriculum management
- Payment oversight
- System-wide analytics
- Content moderation
- Compliance logs

---

### 5.11 Payments & Certificates

**Payments (Paystack):**
- Monthly subscriptions (per child)
- Term-based plans (discounted)
- Bulk school invoicing
- Automatic renewal with email receipts
- Trial period support

**Certificates:**
- Auto-generated PDF on course completion
- QR code verification with unique certificate ID
- Embedded student name, course, date, rank
- Parent-downloadable from dashboard

---

## 6. Club & Curriculum Architecture

| Club | Age Range | Focus Areas |
|------|-----------|-------------|
| **STEM Club** | 7–15 | Python, Scratch, Robotics, Science Experiments |
| **Brain Club** | 5–15 | Logic, Math Olympiad, Puzzles, Lateral Thinking |
| **Art & Craft Club** | 3–12 | Canva Design, Lego StoryStarter, Drawing |
| **Leadership Club** | 8–15 | Debate, Confidence Building, Entrepreneurship, Communication |

---

## 7. Technical Architecture

| Layer | Technology |
|-------|-----------|
| Frontend | TailwindCSS, Alpine.js |
| Backend | PHP (Laravel) |
| Database | MySQL |
| Cache | Redis |
| Hosting | Namecheap Shared cPanel |
| CI/CD | GitHub Actions |
| Auth | OAuth2 via auth.edfrica.org |
| Payments | Paystack API |
| Video | Cloudflare Stream / Vimeo |
| Certificates | Laravel PDF + QR codes |

---

## 8. Non-Functional Requirements

- **Uptime:** 99.9%
- **Mobile-first** responsive design (all dashboards)
- **Page load:** < 3s on 3G
- **Security:** CSRF, XSS protection, rate limiting, audit logging
- **Scalability:** Horizontal DB scaling ready

---

## 9. Analytics & Reporting

**Parent:**
- Weekly learning hours
- XP growth trend (7/30 day)
- Attendance rate
- Course completion progress

**Teacher:**
- Class attendance rates
- Average assessment scores
- Student progress per course

**School:**
- Active student count
- Course completion rates
- License utilization
- Grade distribution

**Admin:**
- Revenue reports
- New registrations
- Platform-wide engagement metrics

---

## 10. Notification Engine

**Channels:** Email, In-app (bell icon + dropdown)

**Triggers:**
- Badge/achievement earned
- Upcoming class reminder (24h before)
- Payment confirmation
- Payment failure alert
- New course available
- Certificate awarded
- Teacher feedback added

---

## 11. AI Layer (Phase 2)

- AI-generated quiz questions from lesson content
- Weak-area detection from assessment patterns
- Smart learning path recommendations
- Basic NLP for profanity detection in submissions

---

## 12. User Journey Flows

### Parent Journey
```
Sign Up → Add Child Profile → Browse Clubs → Enroll in Course → Pay → Track Progress → Download Certificate
```

### Child Journey
```
Login (Username + PIN) → Dashboard → Select Course → Complete Lessons → Earn XP → Level Up → Get Certificate
```

### Teacher Journey
```
Login → View Cohorts → Take Attendance → Conduct Session → Grade Assignments → Award XP
```

### School Journey
```
Sign Contract → Upload Student CSV → Allocate Licenses → Assign Teachers → Monitor Reports
```

---

## 13. Success Metrics (KPIs)

| Metric | Target (M6) |
|--------|-------------|
| Account Activation Rate | > 80% |
| Weekly Active Students | > 1,000 |
| Month-1 Retention | > 60% |
| Month-3 Retention | > 40% |
| Avg XP Growth/Week | > 50 XP |
| Course Completion Rate | > 45% |
| NPS (Parent Survey) | > 50 |

---

## 14. Roadmap

| Milestone | Timeline | Focus |
|-----------|----------|-------|
| **M1** | Weeks 1–2 | Auth, DB Schema, Parent/Child Dashboards |
| **M2** | Weeks 3–4 | LMS Engine, XP System, Payments |
| **M3** | Weeks 5–6 | Teacher Tools, B2B Portal, Certificates |
| **M4** | Weeks 7–8 | QA, Security Audit, Deployment |

---

## 15. Strategic Positioning

TLab is not just an online course platform. It is a **Parent-controlled gamified STEM ecosystem for African children**, differentiating via:

1. **Safety-First Architecture** — No child-to-child messaging, parent-supervised interactions
2. **Family Management** — One parent account manages the entire family's learning
3. **African Future-Skills** — Coding, robotics, AI literacy, entrepreneurship
4. **B2B2C Model** — Schools deploy TLab for entire classrooms with centralized control
5. **Gamified Engagement** — XP, ranks, badges, leaderboards drive sustained motivation
