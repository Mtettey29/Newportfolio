import React, { useState } from 'react';

const Portfolio = () => {
  const [expandedProject, setExpandedProject] = useState(null);

  const toggleProject = (projectId) => {
    setExpandedProject(expandedProject === projectId ? null : projectId);
  };

  const portfolioItems = [
    {
      id: 1,
      title: 'Optimizing Network Infrastructure & Security',
      category: 'featured',
      technologies: ['Wireshark', 'VirtualBox', 'OSI Model', 'VLAN Segmentation', 'IP Subnetting (VLSM)', 'Network Security'],
      image: '/assets/images/project-network.jpg',
      badge: 'Featured Project',
      description: 'Led comprehensive OSI model-based analysis of existing university network infrastructure, identifying critical performance bottlenecks and security vulnerabilities.',
      fullDescription: 'Designed hierarchical network architecture with VLAN segmentation and optimized IP subnetting schemes. Conducted in-depth packet analysis and implemented security vulnerability assessments.',
      highlights: [
        'Analyzed 1.5M network packets using Wireshark',
        'Achieved 3400 IP address conservation through VLSM optimization',
        'Identified 99.2% ARP broadcast dominance inefficiency',
        'Designed comprehensive security vulnerability assessment'
      ],
      details: {
        problem: 'University network infrastructure experiencing performance bottlenecks and security vulnerabilities',
        solution: 'Comprehensive OSI model-based analysis with hierarchical network architecture design',
        results: 'Projected conservation of 3,400 IP addresses, identified 99.2% ARP broadcast dominance, analyzed 1.5M packets',
        date: 'June 2025'
      }
    },
    {
      id: 2,
      title: 'Marketing Campaign Analysis',
      category: 'featured',
      technologies: ['Python', 'Excel', 'Power BI', 'Data Analysis', 'KPI Monitoring'],
      image: '/assets/images/project-marketing.jpg',
      badge: 'Featured Project',
      description: 'Preprocessed and cleaned data from Facebook ad campaigns using Python to analyze key performance indicators (KPIs) and assess campaign effectiveness.',
      fullDescription: 'Designed interactive dashboards to display performance insights and identified cost-saving opportunities through comprehensive campaign analysis and optimization strategies.',
      highlights: [
        'Preprocessed and cleaned Facebook ad campaign data',
        'Analyzed campaign KPIs for effectiveness assessment',
        'Created interactive Power BI dashboards',
        'Identified underperforming campaigns for cost savings'
      ],
      details: {
        problem: 'Facebook ad campaigns lacking performance visibility and optimization insights',
        solution: 'Data preprocessing, KPI analysis, and interactive dashboard development',
        results: 'Identified low-performing campaigns for cost savings, improved campaign ROI by 25%',
        date: 'August 2024'
      }
    }
  ];

  return (
    <div className="min-h-screen bg-gray-50 pt-20">
      {/* Page Header */}
      <section className="bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-20">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
          <h1 className="text-4xl md:text-5xl font-bold mb-4">Portfolio</h1>
          <p className="text-xl text-blue-100 max-w-2xl mx-auto">
            Showcasing my best work and project achievements
          </p>
        </div>
      </section>

      {/* Portfolio Grid */}
      <section className="py-16">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="space-y-12">
            {portfolioItems.map((item) => (
              <div key={item.id} className="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div className="grid lg:grid-cols-2 gap-0">
                  {/* Project Image */}
                  <div className="relative h-64 lg:h-full bg-gradient-to-br from-blue-100 to-indigo-100">
                    <img
                      src={item.image}
                      alt={item.title}
                      className="w-full h-full object-cover"
                      onError={(e) => {
                        e.target.style.display = 'none';
                        e.target.nextSibling.style.display = 'flex';
                      }}
                    />
                    <div className="w-full h-full bg-gradient-to-br from-blue-100 to-indigo-100 hidden items-center justify-center">
                      <div className="text-center text-blue-600">
                        <i className="fas fa-project-diagram text-6xl mb-4"></i>
                        <p className="text-lg font-medium">{item.title}</p>
                      </div>
                    </div>
                    {item.badge && (
                      <div className="absolute top-4 left-4">
                        <span className="bg-blue-600 text-white px-4 py-2 rounded-full text-sm font-medium">
                          {item.badge}
                        </span>
                      </div>
                    )}
                  </div>

                  {/* Project Content */}
                  <div className="p-8 lg:p-12">
                    <h3 className="text-2xl lg:text-3xl font-bold text-gray-900 mb-4">
                      {item.title}
                    </h3>
                    <p className="text-gray-700 mb-6 leading-relaxed">
                      {item.description}
                    </p>

                    {/* Expandable Project Details */}
                    {expandedProject === item.id && (
                      <div className="mb-6 space-y-4">
                        <p className="text-gray-700 leading-relaxed">
                          {item.fullDescription}
                        </p>
                        
                        <div>
                          <h4 className="font-semibold text-gray-900 mb-2">Key Achievements:</h4>
                          <ul className="space-y-2">
                            {item.highlights.map((highlight, idx) => (
                              <li key={idx} className="flex items-start">
                                <i className="fas fa-check text-blue-600 mr-2 mt-1 text-sm"></i>
                                <span className="text-gray-600 text-sm">{highlight}</span>
                              </li>
                            ))}
                          </ul>
                        </div>
                      </div>
                    )}

                    {/* Project Details */}
                    <div className="space-y-4 mb-6">
                      <div>
                        <strong className="text-gray-900">Problem:</strong>
                        <span className="text-gray-700 ml-2">{item.details.problem}</span>
                      </div>
                      <div>
                        <strong className="text-gray-900">Solution:</strong>
                        <span className="text-gray-700 ml-2">{item.details.solution}</span>
                      </div>
                      <div>
                        <strong className="text-gray-900">Results:</strong>
                        <span className="text-gray-700 ml-2">{item.details.results}</span>
                      </div>
                      <div>
                        <strong className="text-gray-900">Date:</strong>
                        <span className="text-gray-700 ml-2">{item.details.date}</span>
                      </div>
                    </div>

                    {/* Technologies */}
                    <div className="mb-6">
                      <strong className="text-gray-900 block mb-3">Technologies:</strong>
                      <div className="flex flex-wrap gap-2">
                        {item.technologies.map((tech, index) => (
                          <span
                            key={index}
                            className="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium"
                          >
                            {tech}
                          </span>
                        ))}
                      </div>
                    </div>

                    {/* Project Links */}
                    <div className="flex flex-col sm:flex-row gap-3">
                      <button 
                        onClick={() => toggleProject(item.id)}
                        className="bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition-colors flex items-center justify-center"
                      >
                        <span className="mr-2">
                          {expandedProject === item.id ? 'Less' : 'More'}
                        </span>
                        <i className={`fas fa-chevron-${expandedProject === item.id ? 'up' : 'down'} transition-transform duration-300`}></i>
                      </button>
                      <button className="border-2 border-blue-600 text-blue-600 px-6 py-3 rounded-lg font-medium hover:bg-blue-50 transition-colors flex items-center justify-center">
                        <i className="fab fa-github mr-2"></i>
                        Source Code
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Call to Action */}
      <section className="py-16 bg-gray-100">
        <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
          <h2 className="text-3xl font-bold text-gray-900 mb-4">
            Interested in Working Together?
          </h2>
          <p className="text-xl text-gray-600 mb-8">
            I'm always open to discussing new opportunities and interesting projects.
          </p>
          <a
            href="/contact"
            className="bg-blue-600 text-white px-8 py-4 rounded-lg font-semibold hover:bg-blue-700 transition-colors inline-flex items-center"
          >
            Get In Touch
            <i className="fas fa-arrow-right ml-2"></i>
          </a>
        </div>
      </section>
    </div>
  );
};

export default Portfolio;