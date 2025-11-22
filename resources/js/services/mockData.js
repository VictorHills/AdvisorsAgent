// FILE: services/mockData.js
// Use this to mock your API responses during development

export const mockDashboardStats = {
    total_students: 156,
    pending_applications: 21,
    approved_applications: 89,
    in_review_applications: 46
}

export const mockMonthlyApplications = {
    labels: [
        "Dec 2024",
        "Jan 2025",
        "Feb 2025",
        "Mar 2025",
        "Apr 2025",
        "May 2025",
        "Jun 2025",
        "Jul 2025",
        "Aug 2025",
        "Sep 2025",
        "Oct 2025",
        "Nov 2025"
    ],
    data: [12, 19, 15, 25, 32, 28, 35, 42, 38, 45, 52, 21]
}

export const mockApplicationsStatus = {
    labels: ["Pending", "Approved", "In Review", "Rejected"],
    data: [21, 89, 46, 12]
}

export const mockApplicationsTrend = {
    labels: ["Nov 16", "Nov 17", "Nov 18", "Nov 19", "Nov 20", "Nov 21", "Nov 22"],
    datasets: [
        {
            label: "Total Applications",
            data: [12, 19, 15, 25, 22, 30, 21]
        },
        {
            label: "Approved",
            data: [8, 12, 10, 18, 15, 22, 14]
        },
        {
            label: "Pending",
            data: [3, 5, 4, 5, 5, 6, 5]
        },
        {
            label: "In Review",
            data: [1, 2, 1, 2, 2, 2, 2]
        }
    ]
}

export const mockStudents = [
    {
        id: 1,
        first_name: "John",
        middle_name: "David",
        last_name: "Smith",
        email: "john.smith@email.com",
        phone_number: "+1 234 567 8901",
        gender: "Male",
        country: "United States",
        created_at: "2025-11-20T10:30:00Z"
    },
    {
        id: 2,
        first_name: "Sarah",
        middle_name: "Jane",
        last_name: "Johnson",
        email: "sarah.j@email.com",
        phone_number: "+44 789 012 3456",
        gender: "Female",
        country: "United Kingdom",
        created_at: "2025-11-19T14:20:00Z"
    },
    {
        id: 3,
        first_name: "Michael",
        middle_name: "James",
        last_name: "Williams",
        email: "m.williams@email.com",
        phone_number: "+1 345 678 9012",
        gender: "Male",
        country: "Canada",
        created_at: "2025-11-18T09:15:00Z"
    },
    {
        id: 4,
        first_name: "Emma",
        middle_name: "Rose",
        last_name: "Brown",
        email: "emma.brown@email.com",
        phone_number: "+61 456 789 0123",
        gender: "Female",
        country: "Australia",
        created_at: "2025-11-17T16:45:00Z"
    },
    {
        id: 5,
        first_name: "Daniel",
        middle_name: "Lee",
        last_name: "Garcia",
        email: "d.garcia@email.com",
        phone_number: "+34 567 890 1234",
        gender: "Male",
        country: "Spain",
        created_at: "2025-11-16T11:30:00Z"
    },
    {
        id: 6,
        first_name: "Olivia",
        middle_name: "Grace",
        last_name: "Martinez",
        email: "olivia.m@email.com",
        phone_number: "+52 678 901 2345",
        gender: "Female",
        country: "Mexico",
        created_at: "2025-11-15T13:00:00Z"
    },
    {
        id: 7,
        first_name: "James",
        middle_name: "Robert",
        last_name: "Anderson",
        email: "james.a@email.com",
        phone_number: "+1 789 012 3456",
        gender: "Male",
        country: "United States",
        created_at: "2025-11-14T08:20:00Z"
    },
    {
        id: 8,
        first_name: "Sophia",
        middle_name: "Marie",
        last_name: "Taylor",
        email: "sophia.t@email.com",
        phone_number: "+49 890 123 4567",
        gender: "Female",
        country: "Germany",
        created_at: "2025-11-13T15:10:00Z"
    }
]


