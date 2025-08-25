# RMB Store - Complete Project Documentation

## 📋 **Project Overview**
This is a CodeIgniter 4 e-commerce project with integrated chatbot functionality, AI integration, and comprehensive product management.

## 🚀 **Features**
- **Frontend**: Responsive mobile-first design with Materialize CSS
- **Chatbot**: AI-powered customer support with FAQ system
- **Product Management**: Complete CRUD operations for products and categories
- **Search**: Advanced product search with fuzzy matching and autosuggest
- **AI Integration**: Google AI and Hugging Face integration for intelligent responses

## 🛠 **Technical Stack**
- **Backend**: CodeIgniter 4 (PHP 8.1+)
- **Frontend**: HTML5, CSS3, JavaScript (jQuery, Materialize CSS)
- **Database**: MySQL
- **AI**: Google AI (Gemini), Hugging Face integration
- **Search**: Advanced fuzzy matching algorithm

## 📁 **Project Structure**
```
rmbstore/
├── app/                    # Application code
│   ├── Controllers/       # MVC Controllers
│   ├── Models/           # Database models
│   ├── Views/            # Frontend views
│   └── Config/           # Configuration files
├── public/                # Public assets
│   ├── assets/           # CSS, JS, images
│   └── uploads/          # User uploads
├── vendor/                # Composer dependencies
└── writable/              # Logs and cache
```

## 🔧 **Setup Instructions**

### **Prerequisites**
- PHP 8.1 or higher
- MySQL/MariaDB
- Composer
- XAMPP/WAMP/LAMP

### **Installation**
1. Clone the repository
2. Run `composer install`
3. Copy `env` to `.env` and configure database
4. Import database schema
5. Run `php spark serve`

### **Database Setup**
- Import the SQL files in the root directory
- Configure database connection in `.env`
- Ensure tables exist: `products`, `categories`, `chatbot_faq`, `settings`

## 🤖 **Chatbot System**

### **Features**
- **FAQ Integration**: Pre-defined Q&A system
- **AI Responses**: Google AI and Hugging Face integration
- **Product Search**: Intelligent product recommendations
- **Conversation History**: Database logging of all interactions

### **Configuration**
- AI API keys in `app/Config/AIProviders.php`
- FAQ management through admin panel
- Customizable responses and fallbacks

## 🔍 **Search System**

### **Advanced Algorithm**
- **Fuzzy Matching**: Handles typos and partial matches
- **Scoring System**: Relevance-based result ranking
- **Multi-field Search**: Product name, category, description
- **Real-time Suggestions**: Autocomplete with product images

### **Features**
- Modal-based search interface
- Responsive design for mobile
- Product cards with images and prices
- Click-to-navigate functionality

## 📱 **Frontend Features**

### **Responsive Design**
- Mobile-first approach
- Materialize CSS framework
- Touch-friendly interface
- Optimized for all screen sizes

### **Components**
- **Navigation**: Collapsible sidebar menu
- **Search**: Modal-based product search
- **Products**: Grid layout with filtering
- **Chatbot**: Floating chat widget

## 🗄 **Database Schema**

### **Core Tables**
- `products`: Product information and images
- `categories`: Product categorization
- `chatbot_faq`: FAQ questions and answers
- `settings`: Application configuration
- `chatbot_conversations`: Chat history logging

### **Relationships**
- Products belong to categories
- FAQ entries support multiple languages
- Settings control application behavior

## 🔐 **Security Features**

### **Input Validation**
- XSS protection with `esc()` helper
- SQL injection prevention
- File upload validation
- CSRF protection

### **Authentication**
- Session-based security
- Admin panel access control
- Secure password handling

## 📊 **Performance Optimization**

### **Frontend**
- Minified CSS and JavaScript
- Optimized images
- Lazy loading for product images
- Efficient search algorithms

### **Backend**
- Database query optimization
- Caching strategies
- Efficient file handling
- Memory management

## 🧪 **Testing**

### **Manual Testing**
- Frontend functionality testing
- Chatbot response testing
- Product search accuracy
- Mobile responsiveness

### **Automated Testing**
- PHPUnit framework (removed for production)
- Database migration testing
- API endpoint validation

## 📈 **Deployment**

### **Production Checklist**
- Remove development dependencies
- Optimize database queries
- Enable caching
- Configure error logging
- Set up monitoring

### **Environment Variables**
- Database credentials
- AI API keys
- Application settings
- Security configurations

## 🐛 **Troubleshooting**

### **Common Issues**
- **Search not working**: Check JavaScript console, verify products loaded
- **Chatbot errors**: Verify AI API keys, check database connections
- **Mobile issues**: Test responsive breakpoints, check CSS media queries
- **Performance**: Monitor database queries, optimize images

### **Debug Tools**
- Browser developer tools
- CodeIgniter logging
- Database query monitoring
- Performance profiling

## 📚 **API Reference**

### **Chatbot Endpoints**
- `POST /chatbot/generateResponse`: Generate AI responses
- `GET /chatbot/getChatHistory`: Retrieve conversation history

### **Product Endpoints**
- `GET /search`: Product search API
- `GET /products`: List all products
- `GET /category/{id}`: Category products

## 🔄 **Maintenance**

### **Regular Tasks**
- Database optimization
- Log file cleanup
- Image optimization
- Security updates
- Performance monitoring

### **Backup Strategy**
- Database backups
- File upload backups
- Configuration backups
- Version control

## 📞 **Support**

### **Documentation**
- This comprehensive guide
- Code comments
- Inline documentation
- API documentation

### **Contact**
- Development team
- Technical support
- Community forums
- Issue tracking

---

**Last Updated**: August 2025
**Version**: 1.0.0
**Status**: Production Ready
